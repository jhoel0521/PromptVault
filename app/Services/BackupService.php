<?php

namespace App\Services;

use App\Contracts\Services\BackupServiceInterface;
use Illuminate\Support\Facades\DB;

class BackupService implements BackupServiceInterface
{
    /**
     * Get the path to backups directory
     */
    private function getBackupsPath(): string
    {
        return storage_path('app/backups');
    }

    /**
     * List all available backups with metadata
     */
    public function listBackups(): array
    {
        $backupsPath = $this->getBackupsPath();
        $backups = [];

        if (! file_exists($backupsPath)) {
            return $backups;
        }

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

        return $backups;
    }

    /**
     * Create a new database backup
     *
     * @return array ['success' => bool, 'filename' => string|null, 'message' => string]
     */
    public function createBackup(): array
    {
        try {
            // Generar nombre del archivo
            $filename = 'backup-promptvault-'.now()->format('Y-m-d-His').'.sql';
            $filepath = $this->getBackupsPath().'/'.$filename;

            // Crear directorio si no existe
            if (! file_exists($this->getBackupsPath())) {
                mkdir($this->getBackupsPath(), 0755, true);
            }

            // Intentar crear backup con mysqldump
            $success = $this->createBackupWithMysqldump($filepath);

            // Si falla, intentar con método PHP puro
            if (! $success) {
                $this->generateSqlBackupPHP($filepath);
            }

            // Verificar si el archivo existe después del backup
            if (! file_exists($filepath)) {
                return [
                    'success' => false,
                    'filename' => null,
                    'message' => 'Error al generar el respaldo. Verifica la configuración de MySQL.',
                ];
            }

            return [
                'success' => true,
                'filename' => $filename,
                'message' => 'Backup generado exitosamente: '.$filename,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'filename' => null,
                'message' => 'Error al generar respaldo: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Create backup using mysqldump command
     */
    private function createBackupWithMysqldump(string $filepath): bool
    {
        // Obtener credenciales de base de datos
        $dbHost = config('database.connections.mysql.host');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPassword = config('database.connections.mysql.password');
        $dbPort = config('database.connections.mysql.port', 3306);

        // Construir comando mysqldump para Windows
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
        return file_exists($filepath) && filesize($filepath) > 0;
    }

    /**
     * Generate SQL backup using PHP (fallback method)
     */
    private function generateSqlBackupPHP(string $filepath): void
    {
        $dbName = config('database.connections.mysql.database');

        // Obtener todas las tablas
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_'.$dbName;

        $sql = "-- PromptVault Database Backup\n";
        $sql .= '-- Generated: '.now()->format('Y-m-d H:i:s')."\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            // Obtener estructura de la tabla
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= $createTable[0]->{'Create Table'}.";\n\n";

            // Obtener datos de la tabla
            $rows = DB::table($tableName)->get();

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
     * Download an existing backup file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function downloadBackup(string $filename)
    {
        $filepath = $this->getBackupsPath().'/'.$filename;

        // Validar que el archivo existe y es .sql
        if (! file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            abort(404, 'Backup no encontrado');
        }

        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Delete an existing backup file
     *
     * @return array ['success' => bool, 'message' => string]
     */
    public function deleteBackup(string $filename): array
    {
        $filepath = $this->getBackupsPath().'/'.$filename;

        // Validar que el archivo existe y es .sql
        if (! file_exists($filepath) || pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
            return [
                'success' => false,
                'message' => 'Backup no encontrado',
            ];
        }

        // Eliminar archivo
        if (unlink($filepath)) {
            return [
                'success' => true,
                'message' => 'Backup eliminado correctamente',
            ];
        }

        return [
            'success' => false,
            'message' => 'Error al eliminar el backup',
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }
}
