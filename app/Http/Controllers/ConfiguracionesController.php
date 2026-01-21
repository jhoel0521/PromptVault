<?php

namespace App\Http\Controllers;

use App\Contracts\Services\BackupServiceInterface;
use App\Contracts\Services\ConfigurationServiceInterface;
use Illuminate\Http\Request;

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
    public function update(Request $request)
    {
        // Validar entrada
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'nullable|url',
            'app_env' => 'nullable|string|max:50',
            'app_locale' => 'nullable|string|max:10',
            'app_fallback_locale' => 'nullable|string|max:10',
            'support_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'maintenance_mode' => 'nullable|boolean',
            'theme' => 'nullable|in:dark,light',
            'language' => 'nullable|in:es,en',
            'mail_mailer' => 'nullable|string|max:50',
            'mail_host' => 'nullable|string|max:150',
            'mail_port' => 'nullable|integer',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string|max:150',
            'session_driver' => 'nullable|string|max:50',
            'cache_store' => 'nullable|string|max:50',
            'queue_connection' => 'nullable|string|max:50',
            // Seguridad - Políticas de Acceso
            'two_fa_enabled' => 'nullable|boolean',
            'session_timeout' => 'nullable|integer|min:5|max:1440',
            'max_login_attempts' => 'nullable|integer|min:1|max:20',
            'geo_blocking_enabled' => 'nullable|boolean',
            // Seguridad - Contraseñas
            'password_min_length' => 'nullable|integer|min:8|max:32',
            'password_expiry_days' => 'nullable|integer|min:1|max:365',
            'password_require_special_chars' => 'nullable|boolean',
            'password_force_rotation' => 'nullable|boolean',
        ]);

        // Procesar checkboxes (no enviados = false)
        $validated['maintenance_mode'] = $request->boolean('maintenance_mode');
        $validated['two_fa_enabled'] = $request->boolean('two_fa_enabled');
        $validated['geo_blocking_enabled'] = $request->boolean('geo_blocking_enabled');
        $validated['password_require_special_chars'] = $request->boolean('password_require_special_chars');
        $validated['password_force_rotation'] = $request->boolean('password_force_rotation');

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
