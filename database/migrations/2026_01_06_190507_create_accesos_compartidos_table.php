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
        Schema::create('accesos_compartidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('nivel_acceso', ['lector', 'comentador', 'editor'])->default('lector');
            $table->timestamps();

            $table->unique(['prompt_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesos_compartidos');
    }
};
