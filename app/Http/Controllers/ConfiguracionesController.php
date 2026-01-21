<?php

namespace App\Http\Controllers;

use App\Contracts\Services\BackupServiceInterface;
use App\Contracts\Services\ConfigurationServiceInterface;
use App\Http\Requests\Configuracion\UpdateConfiguracionRequest;

class ConfiguracionesController extends Controller
{
    public function __construct(
        private readonly ConfigurationServiceInterface $configService,
        private readonly BackupServiceInterface $backupService
    ) {}

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
        $settings = $this->configService->getSettings();

        return view('configuraciones.general', compact('settings'));
    }

    /**
     * Show the security settings page.
     */
    public function seguridad()
    {
        $settings = $this->configService->getSettings();

        return view('configuraciones.seguridad', compact('settings'));
    }

    /**
     * Show the notifications settings page.
     */
    public function notificaciones()
    {
        $settings = $this->configService->getSettings();

        return view('configuraciones.notificaciones', compact('settings'));
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
        $backups = $this->backupService->listBackups();

        return view('configuraciones.respaldos', compact('backups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConfiguracionRequest $request)
    {
        // Autorización y validación: manejadas en UpdateConfiguracionRequest
        $validated = $request->validated();

        $this->configService->updateSettings($validated);

        return redirect()->back()->with('success', 'Configuración actualizada exitosamente.');
    }

    /**
     * Create database backup (save to storage)
     */
    public function createBackup()
    {
        $result = $this->backupService->createBackup();

        return $result['success']
            ? back()->with('success', $result['message'])
            : back()->with('error', $result['message']);
    }

    /**
     * Download existing backup
     */
    public function downloadExistingBackup(string $filename)
    {
        return $this->backupService->downloadBackup($filename);
    }

    /**
     * Delete existing backup
     */
    public function deleteBackup(string $filename)
    {
        $result = $this->backupService->deleteBackup($filename);

        return $result['success']
            ? back()->with('success', $result['message'])
            : back()->with('error', $result['message']);
    }
}
