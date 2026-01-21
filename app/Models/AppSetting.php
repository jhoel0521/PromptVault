<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_settings';

    protected $fillable = [
        'app_name',
        'support_email',
        'contact_phone',
        'maintenance_mode',
        'description',
        'theme',
        'language',
        'app_url',
        'app_env',
        'app_locale',
        'app_fallback_locale',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_from_address',
        'mail_from_name',
        'session_driver',
        'cache_store',
        'queue_connection',
        // Seguridad
        'two_fa_enabled',
        'session_timeout',
        'max_login_attempts',
        'geo_blocking_enabled',
        'password_min_length',
        'password_expiry_days',
        'password_require_special_chars',
        'password_force_rotation',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'mail_port' => 'integer',
        'two_fa_enabled' => 'boolean',
        'session_timeout' => 'integer',
        'max_login_attempts' => 'integer',
        'geo_blocking_enabled' => 'boolean',
        'password_min_length' => 'integer',
        'password_expiry_days' => 'integer',
        'password_require_special_chars' => 'boolean',
        'password_force_rotation' => 'boolean',
    ];

    /**
     * Obtener la configuración activa (singleton)
     */
    public static function getSettings()
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'PromptVault',
                'app_url' => env('APP_URL'),
                'app_env' => env('APP_ENV', 'local'),
                'app_locale' => env('APP_LOCALE', 'en'),
                'app_fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
                'support_email' => env('MAIL_FROM_ADDRESS'),
                'contact_phone' => null,
                'maintenance_mode' => false,
                'description' => 'Biblioteca de Prompts para IA',
                'theme' => 'dark',
                'language' => env('APP_LOCALE', 'es'),
                'mail_mailer' => env('MAIL_MAILER', 'log'),
                'mail_host' => env('MAIL_HOST'),
                'mail_port' => env('MAIL_PORT'),
                'mail_from_address' => env('MAIL_FROM_ADDRESS'),
                'mail_from_name' => env('MAIL_FROM_NAME'),
                'session_driver' => env('SESSION_DRIVER', 'file'),
                'cache_store' => env('CACHE_STORE', 'file'),
                'queue_connection' => env('QUEUE_CONNECTION', 'sync'),
                // Seguridad - Valores por defecto
                'two_fa_enabled' => false,
                'session_timeout' => 120,
                'max_login_attempts' => 5,
                'geo_blocking_enabled' => true,
                'password_min_length' => 12,
                'password_expiry_days' => 90,
                'password_require_special_chars' => true,
                'password_force_rotation' => false,
            ]
        );
    }
}
