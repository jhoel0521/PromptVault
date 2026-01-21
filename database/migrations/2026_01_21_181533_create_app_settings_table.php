<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('PromptVault');
            $table->string('app_url')->nullable();
            $table->string('app_env')->default('local');
            $table->string('app_locale')->default('en');
            $table->string('app_fallback_locale')->default('en');
            $table->string('support_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->boolean('maintenance_mode')->default(false);
            $table->text('description')->nullable();
            $table->string('theme')->default('dark')->comment('dark, light');
            $table->string('language')->default('es');
            $table->string('mail_mailer')->default('log');
            $table->string('mail_host')->nullable();
            $table->integer('mail_port')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->string('session_driver')->default('file');
            $table->string('cache_store')->default('file');
            $table->string('queue_connection')->default('sync');
            // Seguridad - Políticas de Acceso
            $table->boolean('two_fa_enabled')->default(false)->comment('Autenticación 2FA');
            $table->integer('session_timeout')->default(120)->comment('Timeout en minutos');
            $table->integer('max_login_attempts')->default(5)->comment('Intentos fallidos permitidos');
            $table->boolean('geo_blocking_enabled')->default(true)->comment('Bloqueo geográfico');
            // Seguridad - Contraseñas
            $table->integer('password_min_length')->default(12)->comment('Longitud mínima');
            $table->integer('password_expiry_days')->default(90)->comment('Expiración en días');
            $table->boolean('password_require_special_chars')->default(true)->comment('Requiere caracteres especiales');
            $table->boolean('password_force_rotation')->default(false)->comment('Forzar renovación en próximo login');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
