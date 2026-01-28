<?php

namespace Tests\Unit\Services;

use App\Services\BackupService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BackupServiceTest extends TestCase
{
    private BackupService $service;

    private string $backupsPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(BackupService::class);
        $this->backupsPath = storage_path('app/backups');
    }

    protected function tearDown(): void
    {
        // Limpiar archivos de backup creados durante tests
        if (File::exists($this->backupsPath)) {
            File::cleanDirectory($this->backupsPath);
        }

        parent::tearDown();
    }

    /**
     * Test que crear respaldo genera archivo SQL
     */
    public function test_crear_respaldo_genera_archivo(): void
    {
        // Crear backup
        $resultado = $this->service->createBackup();

        // Validar resultado
        $this->assertTrue($resultado['success'], $resultado['message'] ?? 'Error al crear backup');
        $this->assertNotNull($resultado['filename']);
        $this->assertStringContainsString('backup-promptvault-', $resultado['filename']);
        $this->assertStringEndsWith('.sql', $resultado['filename']);

        // Validar que el archivo existe
        $filepath = $this->backupsPath.'/'.$resultado['filename'];
        $this->assertFileExists($filepath);

        // Validar que tiene contenido
        $this->assertGreaterThan(0, filesize($filepath));
    }

    /**
     * Test que listar respaldos devuelve archivos con metadata
     */
    public function test_listar_respaldos_devuelve_archivos(): void
    {
        // Crear directorio si no existe
        if (! File::exists($this->backupsPath)) {
            File::makeDirectory($this->backupsPath, 0755, true);
        }

        // Crear archivos de backup de prueba
        $filename1 = 'backup-promptvault-2026-01-27-120000.sql';
        $filename2 = 'backup-promptvault-2026-01-28-150000.sql';

        File::put($this->backupsPath.'/'.$filename1, 'SQL DUMP CONTENT 1');
        sleep(1); // Asegurar que tienen timestamps diferentes
        File::put($this->backupsPath.'/'.$filename2, 'SQL DUMP CONTENT 2');

        // Listar backups
        $backups = $this->service->listBackups();

        // Validar resultados
        $this->assertIsArray($backups);
        $this->assertCount(2, $backups);

        // Validar estructura del primer backup
        $this->assertArrayHasKey('filename', $backups[0]);
        $this->assertArrayHasKey('size', $backups[0]);
        $this->assertArrayHasKey('size_formatted', $backups[0]);
        $this->assertArrayHasKey('date', $backups[0]);
        $this->assertArrayHasKey('date_formatted', $backups[0]);

        // Validar que están ordenados por fecha descendente (más reciente primero)
        $this->assertEquals($filename2, $backups[0]['filename']);
        $this->assertEquals($filename1, $backups[1]['filename']);

        // Test con directorio vacío
        File::cleanDirectory($this->backupsPath);
        $backupsVacios = $this->service->listBackups();
        $this->assertIsArray($backupsVacios);
        $this->assertCount(0, $backupsVacios);
    }
}
