<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Prompt;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calificaciones = [
            // Calificaciones para prompt 2 (público)
            ['prompt_id' => 2, 'user_id' => 3, 'estrellas' => 5, 'resena' => 'Excelente estructura para informes profesionales.'],
            ['prompt_id' => 2, 'user_id' => 5, 'estrellas' => 4, 'resena' => 'Muy útil, faltaría más detalle en la sección de análisis.'],
            ['prompt_id' => 2, 'user_id' => 7, 'estrellas' => 5],
            ['prompt_id' => 2, 'user_id' => 8, 'estrellas' => 4],

            // Calificaciones para prompt 4 (público)
            ['prompt_id' => 4, 'user_id' => 3, 'estrellas' => 5, 'resena' => 'Perfecto para community managers.'],
            ['prompt_id' => 4, 'user_id' => 5, 'estrellas' => 5],
            ['prompt_id' => 4, 'user_id' => 7, 'estrellas' => 4, 'resena' => 'Buenos resultados con Gemini.'],
            ['prompt_id' => 4, 'user_id' => 9, 'estrellas' => 5],
            ['prompt_id' => 4, 'user_id' => 10, 'estrellas' => 4],

            // Calificaciones para prompt 8 (público)
            ['prompt_id' => 8, 'user_id' => 3, 'estrellas' => 5, 'resena' => 'Como docente, este prompt me ahorra horas de trabajo.'],
            ['prompt_id' => 8, 'user_id' => 4, 'estrellas' => 5],
            ['prompt_id' => 8, 'user_id' => 5, 'estrellas' => 4],
            ['prompt_id' => 8, 'user_id' => 9, 'estrellas' => 3, 'resena' => 'Bueno pero podría incluir más variedad de actividades.'],

            // Algunas calificaciones para prompts compartidos
            ['prompt_id' => 1, 'user_id' => 4, 'estrellas' => 5, 'resena' => 'Muy completo para code review.'],
            ['prompt_id' => 3, 'user_id' => 6, 'estrellas' => 5],
        ];

        foreach ($calificaciones as $calificacionData) {
            Calificacion::create($calificacionData);
        }

        // Recalcular promedios para todos los prompts que tienen calificaciones
        $promptIds = collect($calificaciones)->pluck('prompt_id')->unique();
        foreach ($promptIds as $promptId) {
            $prompt = Prompt::find($promptId);
            if ($prompt) {
                $prompt->recalcularPromedio();
            }
        }
    }
}
