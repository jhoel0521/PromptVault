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
        Schema::create('prompt_etiquetas', function (Blueprint $table) {
            $table->foreignId('prompt_id')->constrained()->onDelete('cascade');
            $table->foreignId('etiqueta_id')->constrained()->onDelete('cascade');

            $table->primary(['prompt_id', 'etiqueta_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_etiquetas');
    }
};
