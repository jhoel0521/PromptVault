<?php

namespace Database\Seeders;

use App\Models\Comentario;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comentarios = [
            // Comentarios en prompt 2 (público)
            [
                'prompt_id' => 2,
                'user_id' => 3,
                'contenido' => '¡Excelente prompt! Lo uso todos los días para mis informes.',
            ],
            [
                'prompt_id' => 2,
                'user_id' => 5,
                'contenido' => 'Muy útil. Sugeriría agregar una sección de anexos.',
            ],
            [
                'prompt_id' => 2,
                'user_id' => 4,
                'contenido' => 'Gracias por el feedback, lo consideraré para la próxima versión.',
                'parent_id' => 2, // Respuesta al comentario anterior
            ],

            // Comentarios en prompt 4 (público)
            [
                'prompt_id' => 4,
                'user_id' => 7,
                'contenido' => 'Perfecto para planificar contenido de redes sociales.',
            ],
            [
                'prompt_id' => 4,
                'user_id' => 8,
                'contenido' => '¿Funciona bien con Gemini o solo ChatGPT?',
            ],
            [
                'prompt_id' => 4,
                'user_id' => 6,
                'contenido' => 'Funciona excelente con ambos, pero obtuve mejores resultados con Gemini.',
                'parent_id' => 5, // Respuesta
            ],

            // Comentarios en prompt 8 (público)
            [
                'prompt_id' => 8,
                'user_id' => 3,
                'contenido' => 'Lo usé para preparar una clase de matemáticas y funcionó genial.',
            ],
            [
                'prompt_id' => 8,
                'user_id' => 9,
                'contenido' => 'Muy completo. ¿Tienes uno para clases de 90 minutos?',
            ],

            // Comentarios en prompts privados compartidos
            [
                'prompt_id' => 1,
                'user_id' => 4,
                'contenido' => 'El análisis de code smells es muy acertado.',
            ],
            [
                'prompt_id' => 3,
                'user_id' => 6,
                'contenido' => 'La actualización a Sanctum fue una gran mejora.',
            ],
        ];

        foreach ($comentarios as $index => $comentarioData) {
            Comentario::create(array_merge($comentarioData, [
                'parent_id' => $comentarioData['parent_id'] ?? null,
            ]));
        }
    }
}
