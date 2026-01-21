<?php

namespace App\Contracts\Services;

interface BackupServiceInterface
{
    /**
     * List all available backups with metadata
     */
    public function listBackups(): array;

    /**
     * Create a new database backup
     *
     * @return array ['success' => bool, 'filename' => string|null, 'message' => string]
     */
    public function createBackup(): array;

    /**
     * Download an existing backup file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function downloadBackup(string $filename);

    /**
     * Delete an existing backup file
     *
     * @return array ['success' => bool, 'message' => string]
     */
    public function deleteBackup(string $filename): array;
}
