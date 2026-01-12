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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo', 150);
            $table->text('contenido');
            $table->text('descripcion')->nullable();
            $table->enum('visibilidad', ['privado', 'publico', 'enlace'])->default('privado');
            $table->integer('version_actual')->default(1);
            $table->decimal('promedio_calificacion', 3, 2)->default(0);
            $table->integer('conteo_vistas')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
