<?php

namespace Database\Seeders;

use App\Models\Prompt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prompts = [
            [
                'user_id' => 3,
                'titulo' => 'Revisar código Python',
                'contenido' => 'Analiza el siguiente código Python y sugiere mejoras en rendimiento y legibilidad. Identifica posibles bugs y propón soluciones.',
                'descripcion' => 'Prompt para revisión de código',
                'visibilidad' => 'privado',
            ],
            [
                'user_id' => 4,
                'titulo' => 'Redactar informe técnico',
                'contenido' => 'Crea un informe técnico profesional sobre [TEMA] con estructura: resumen ejecutivo, introducción, análisis, conclusiones y recomendaciones.',
                'descripcion' => 'Estructura para informes técnicos',
                'visibilidad' => 'publico',
            ],
            [
                'user_id' => 5,
                'titulo' => 'Crear API REST Laravel',
                'contenido' => 'Genera el código para una API REST en Laravel con autenticación Sanctum, CRUD completo para [ENTIDAD] y validaciones.',
                'descripcion' => 'Generador de APIs REST',
                'visibilidad' => 'enlace',
            ],
            [
                'user_id' => 6,
                'titulo' => 'Estrategia redes sociales',
                'contenido' => 'Diseña una estrategia de contenido para redes sociales dirigida a [PÚBLICO OBJETIVO] con calendario mensual y métricas clave.',
                'descripcion' => 'Planificación de marketing digital',
                'visibilidad' => 'publico',
            ],
            [
                'user_id' => 3,
                'titulo' => 'Optimizar consultas SQL',
                'contenido' => 'Revisa estas consultas SQL y optimízalas para mejorar el rendimiento. Sugiere índices apropiados y explica cada mejora.',
                'descripcion' => 'Optimización de base de datos',
                'visibilidad' => 'privado',
            ],
            [
                'user_id' => 4,
                'titulo' => 'Manual de usuario',
                'contenido' => 'Redacta un manual de usuario para [SOFTWARE] con guía paso a paso, capturas y solución de problemas comunes.',
                'descripcion' => 'Documentación técnica',
                'visibilidad' => 'enlace',
            ],
            [
                'user_id' => 7,
                'titulo' => 'Diseño de interfaz web',
                'contenido' => 'Crea wireframes y mockups para una interfaz web moderna con enfoque en UX/UI. Incluye paleta de colores y tipografía.',
                'descripcion' => 'Diseño UI/UX',
                'visibilidad' => 'privado',
            ],
            [
                'user_id' => 8,
                'titulo' => 'Plan de clase interactivo',
                'contenido' => 'Desarrolla un plan de clase de 45 minutos sobre [TEMA] con actividades interactivas y evaluación formativa.',
                'descripcion' => 'Planificación educativa',
                'visibilidad' => 'publico',
            ],
            [
                'user_id' => 9,
                'titulo' => 'Análisis de datos ventas',
                'contenido' => 'Analiza el conjunto de datos de ventas y genera insights clave. Incluye tendencias, patrones y recomendaciones.',
                'descripcion' => 'Análisis estadístico',
                'visibilidad' => 'privado',
            ],
            [
                'user_id' => 5,
                'titulo' => 'Tests unitarios automáticos',
                'contenido' => 'Genera tests unitarios completos para la clase [NOMBRE] usando PHPUnit. Incluye casos edge y mocks necesarios.',
                'descripcion' => 'Testing automatizado',
                'visibilidad' => 'enlace',
            ],
        ];

        foreach ($prompts as $promptData) {
            $prompt = Prompt::create(array_merge($promptData, [
                'version_actual' => 1,
            ]));

            // Asignar etiquetas aleatorias (2-4 por prompt)
            $etiquetas = DB::table('etiquetas')->inRandomOrder()->limit(rand(2, 4))->pluck('id');
            $prompt->etiquetas()->attach($etiquetas);
        }
    }
}
