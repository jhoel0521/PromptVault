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
