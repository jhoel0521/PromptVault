<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Redirect to general settings by default
        return redirect()->route('admin.configuraciones.general');
    }

    /**
     * Show the general settings page.
     */
    public function general()
    {
        return view('configuraciones.general');
    }

    /**
     * Show the security settings page.
     */
    public function seguridad()
    {
        return view('configuraciones.seguridad');
    }

    /**
     * Show the notifications settings page.
     */
    public function notificaciones()
    {
        return view('configuraciones.notificaciones');
    }

    /**
     * Show the appearance settings page.
     */
    public function apariencia()
    {
        return view('configuraciones.apariencia');
    }

    /**
     * Show the system settings page.
     */
    public function sistema()
    {
        return view('configuraciones.sistema');
    }

    /**
     * Show the backups settings page.
     */
    public function respaldos()
    {
        // Obtener lista de backups existentes
        $backupsPath = storage_path('app/backups');
        $backups = [];

        if (file_exists($backupsPath)) {
            $files = array_diff(scandir($backupsPath), ['.', '..']);

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filepath = $backupsPath.'/'.$file;
                    $backups[] = [
                        'filename' => $file,
                        'size' => filesize($filepath),
                        'size_formatted' => $this->formatBytes(filesize($filepath)),
                        'date' => filemtime($filepath),
                        'date_formatted' => date('d/m/Y H:i:s', filemtime($filepath)),
                    ];
                }
            }

            // Ordenar por fecha descendente (más recientes primero)
            usort($backups, function ($a, $b) {
                return $b['date'] - $a['date'];
            });
        }

        return view('configuraciones.respaldos', compact('backups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Lógica para actualizar configuraciones
        return redirect()->route('configuraciones.index')->with('success', 'Configuración actualizada exitosamente.');
    }

    /**
     * Create database backup (save to storage)
     */
    public function createBackup()
    {
        try {
            // Generar nombre del archivo
            $filename = 'backup-promptvault-'.now()->format('Y-m-d-His').'.sql';
            $filepath = storage_path('app/backups/'.$filename);

            // Crear directorio si no existe
            if (! file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // Obtener credenciales de base de datos
            $dbHost = config('database.connections.mysql.host');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPassword = config('database.connections.mysql.password');
            $dbPort = config('database.connections.mysql.port', 3306);

            // Construir comando mysqldump para Windows
            // Escapar password para manejar caracteres especiales
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s %s > "%s" 2>&1',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                escapeshellarg($dbPassword),
                escapeshellarg($dbName),
                $filepath
            );

            // Ejecutar comando
            exec($command, $output, $returnVar);

            // Verificar si el archivo fue creado y no está vacío
            if (! file_exists($filepath) || filesize($filepath) === 0) {
                // Intentar método alternativo con PHP puro
                $this->generateSqlBackupPHP($filepath);
            }

            // Verificar si el archivo existe después del backup
            if (! file_exists($filepath)) {
                return back()->with('error', 'Error al generar el respaldo. Verifica la configuración de MySQL.');
            }

            // Redirigir con mensaje de éxito
            return back()->with('success', 'Backup generado exitosamente: '.$filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar respaldo: '.$e->getMessage());
        }
    }

    /**
     * Generate SQL backup using PHP (fallback method)
     */
    private function generateSqlBackupPHP($filepath)
    {
        $dbName = config('database.connections.mysql.database');

        // Obtener todas las tablas
        $tables = \DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_'.$dbName;

        $sql = "-- PromptVault Database Backup\n";
        $sql .= '-- Generated: '.now()->format('Y-m-d H:i:s')."\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            // Obtener estructura de la tabla
            $createTable = \DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= $createTable[0]->{'Create Table'}.";\n\n";

            // Obtener datos de la tabla
            $rows = \DB::table($tableName)->get();

            if ($rows->count() > 0) {
                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        if (is_null($value)) {
                            return 'NULL';
                        }

                        return "'".addslashes($value)."'";
                    }, (array) $row);

                    $sql .= "INSERT INTO `$tableName` VALUES (".implode(', ', $values).");\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        // Guardar archivo
        file_put_contents($filepath, $sql);
    }

    /**
     * Download existing backup
     */
    public function downloadExistingBackup($filename)
    {
        $filepath = storage_path('app/backups/'.$filename);

        // Validar que el archivo existe y es .sql
        if (! file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            abort(404, 'Backup no encontrado');
        }

        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Delete existing backup
     */
    public function deleteBackup($filename)
    {
        $filepath = storage_path('app/backups/'.$filename);

        // Validar que el archivo existe y es .sql
        if (! file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            return back()->with('error', 'Backup no encontrado');
        }

        // Eliminar archivo
        if (unlink($filepath)) {
            return back()->with('success', 'Backup eliminado correctamente');
        }

        return back()->with('error', 'Error al eliminar el backup');
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }
}
