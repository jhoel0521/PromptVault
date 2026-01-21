<?php

if (! function_exists('appName')) {
    /**
     * Obtener el nombre de la aplicación desde la BD o fallback a env
     */
    function appName(): string
    {
        try {
            $settings = \App\Models\AppSetting::getSettings();

            return $settings->app_name ?: config('app.name');
        } catch (\Exception $e) {
            // Si hay error (BD no lista), fallback a config
            return config('app.name');
        }
    }
}
