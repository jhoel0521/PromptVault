<?php

namespace Database\Seeders;

use App\Models\AccesoCompartido;
use Illuminate\Database\Seeder;

class AccesoCompartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accesos = [
            // Prompt 1 compartido con usuarios
            ['prompt_id' => 1, 'user_id' => 4, 'nivel_acceso' => 'editor'],
            ['prompt_id' => 1, 'user_id' => 5, 'nivel_acceso' => 'comentador'],

            // Prompt 3 compartido con usuarios
            ['prompt_id' => 3, 'user_id' => 3, 'nivel_acceso' => 'lector'],
            ['prompt_id' => 3, 'user_id' => 6, 'nivel_acceso' => 'editor'],

            // Prompt 5 compartido
            ['prompt_id' => 5, 'user_id' => 4, 'nivel_acceso' => 'comentador'],
            ['prompt_id' => 5, 'user_id' => 7, 'nivel_acceso' => 'lector'],

            // Prompt 6 compartido
            ['prompt_id' => 6, 'user_id' => 3, 'nivel_acceso' => 'editor'],
            ['prompt_id' => 6, 'user_id' => 8, 'nivel_acceso' => 'comentador'],

            // Prompt 7 compartido
            ['prompt_id' => 7, 'user_id' => 4, 'nivel_acceso' => 'lector'],
            ['prompt_id' => 7, 'user_id' => 5, 'nivel_acceso' => 'comentador'],

            // Prompt 9 compartido
            ['prompt_id' => 9, 'user_id' => 3, 'nivel_acceso' => 'editor'],
            ['prompt_id' => 9, 'user_id' => 10, 'nivel_acceso' => 'comentador'],

            // Prompt 10 compartido
            ['prompt_id' => 10, 'user_id' => 3, 'nivel_acceso' => 'lector'],
            ['prompt_id' => 10, 'user_id' => 6, 'nivel_acceso' => 'editor'],
        ];

        foreach ($accesos as $acceso) {
            AccesoCompartido::create($acceso);
        }
    }
}
