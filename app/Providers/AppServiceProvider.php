<?php

namespace App\Providers;

use App\Contracts\Services\BackupServiceInterface;
use App\Contracts\Services\ConfigurationServiceInterface;
use App\Services\BackupService;
use App\Services\ConfigurationService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind BackupService
        $this->app->bind(BackupServiceInterface::class, BackupService::class);

        // Bind ConfigurationService
        $this->app->bind(ConfigurationServiceInterface::class, ConfigurationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate para verificar si el usuario es admin
        Gate::define('admin', function ($user) {
            return $user->esAdmin();
        });

        // Gate para verificar permisos específicos
        Gate::define('gestionar-usuarios', function ($user) {
            return $user->esAdmin() || $user->tienePermiso('usuarios.gestionar');
        });
    }
}
