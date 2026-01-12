<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etiquetas = [
            // Categorías convertidas a etiquetas (con sus colores)
            ['nombre' => 'Programación', 'color_hex' => '#3B82F6'],
            ['nombre' => 'Redacción', 'color_hex' => '#10B981'],
            ['nombre' => 'Análisis', 'color_hex' => '#F59E0B'],
            ['nombre' => 'Marketing', 'color_hex' => '#EC4899'],
            ['nombre' => 'Educación', 'color_hex' => '#8B5CF6'],
            ['nombre' => 'Diseño', 'color_hex' => '#EF4444'],

            // IAs
            ['nombre' => 'ChatGPT', 'color_hex' => '#10A37F'],
            ['nombre' => 'Claude', 'color_hex' => '#D97706'],
            ['nombre' => 'Gemini', 'color_hex' => '#4285F4'],
            ['nombre' => 'Copilot', 'color_hex' => '#0078D4'],

            // Lenguajes
            ['nombre' => 'Python', 'color_hex' => '#3776AB'],
            ['nombre' => 'JavaScript', 'color_hex' => '#F7DF1E'],
            ['nombre' => 'PHP', 'color_hex' => '#777BB4'],
            ['nombre' => 'Laravel', 'color_hex' => '#FF2D20'],
            ['nombre' => 'SQL', 'color_hex' => '#336791'],

            // Otros
            ['nombre' => 'API', 'color_hex' => '#6366F1'],
            ['nombre' => 'Testing', 'color_hex' => '#22C55E'],
            ['nombre' => 'Debug', 'color_hex' => '#DC2626'],
            ['nombre' => 'SEO', 'color_hex' => '#059669'],
            ['nombre' => 'Tutorial', 'color_hex' => '#7C3AED'],
        ];

        foreach ($etiquetas as $etiqueta) {
            Etiqueta::create($etiqueta);
        }
    }
}
