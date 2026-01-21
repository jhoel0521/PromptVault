<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@promptvault.com')->first();

        if (! $admin) {
            $this->command->warn('No se encontró usuario admin, saltando PromptSeeder');

            return;
        }

        // Crear etiquetas
        $etiquetas = [
            'Marketing' => Etiqueta::firstOrCreate(['nombre' => 'Marketing']),
            'SEO' => Etiqueta::firstOrCreate(['nombre' => 'SEO']),
            'Desarrollo' => Etiqueta::firstOrCreate(['nombre' => 'Desarrollo']),
            'Diseño' => Etiqueta::firstOrCreate(['nombre' => 'Diseño']),
            'Contenido' => Etiqueta::firstOrCreate(['nombre' => 'Contenido']),
            'Email' => Etiqueta::firstOrCreate(['nombre' => 'Email']),
            'Social Media' => Etiqueta::firstOrCreate(['nombre' => 'Social Media']),
            'Blog' => Etiqueta::firstOrCreate(['nombre' => 'Blog']),
            'Video' => Etiqueta::firstOrCreate(['nombre' => 'Video']),
            'Análisis' => Etiqueta::firstOrCreate(['nombre' => 'Análisis']),
            'Código' => Etiqueta::firstOrCreate(['nombre' => 'Código']),
            'Documentación' => Etiqueta::firstOrCreate(['nombre' => 'Documentación']),
        ];

        $prompts = [
            [
                'titulo' => 'Generador de títulos SEO optimizados',
                'descripcion' => 'Crea títulos atractivos optimizados para SEO',
                'contenido' => "Actúa como experto en SEO. Genera 10 títulos optimizados para SEO sobre el tema: [TEMA]\n\nRequisitos:\n- Máximo 60 caracteres\n- Incluir palabra clave principal\n- Atractivo para CTR\n- Incluir números o preguntas cuando sea posible\n\nFormato: Lista numerada con título + razón por la que funciona",
                'visibilidad' => 'publico',
                'etiquetas' => ['SEO', 'Marketing', 'Contenido'],
                'versiones' => [
                    "Actúa como experto en SEO. Genera títulos optimizados sobre: [TEMA]\n\nRequisitos:\n- 50-60 caracteres\n- Palabra clave al inicio\n- Atractivo\n\nLista de 5 títulos",
                    "Como especialista SEO, crea títulos para: [TEMA]\n\nCriterios:\n- Máximo 60 caracteres\n- Keyword principal\n- CTR alto\n\n10 opciones con análisis",
                ],
            ],
            [
                'titulo' => 'Creador de posts para redes sociales',
                'descripcion' => 'Genera contenido atractivo para diferentes plataformas',
                'contenido' => "Eres un community manager experto. Crea posts para [PLATAFORMA] sobre: [TEMA]\n\nEstructura para cada post:\n1. Hook impactante (primera línea)\n2. Desarrollo del contenido (2-3 párrafos)\n3. Call-to-action claro\n4. 3-5 hashtags relevantes\n\nTono: [PROFESIONAL/CASUAL/INSPIRADOR]\n\nGenera 3 variaciones diferentes optimizadas para máximo engagement",
                'visibilidad' => 'publico',
                'etiquetas' => ['Social Media', 'Marketing', 'Contenido'],
                'versiones' => [
                    "Como community manager, crea post para [PLATAFORMA]: [TEMA]\n\nIncluye:\n- Hook\n- Contenido\n- CTA\n- Hashtags\n\n1 variación",
                ],
            ],
            [
                'titulo' => 'Revisor de código con mejores prácticas',
                'descripcion' => 'Analiza y sugiere mejoras en fragmentos de código',
                'contenido' => "Actúa como senior developer especializado en [LENGUAJE]. Revisa este código:\n\n```[LENGUAJE]\n[CÓDIGO]\n```\n\nAnaliza:\n1. Errores potenciales\n2. Mejoras de rendimiento\n3. Mejores prácticas no aplicadas\n4. Vulnerabilidades de seguridad\n5. Legibilidad y mantenibilidad\n\nPara cada punto, proporciona:\n- Explicación del problema\n- Código mejorado\n- Razón de la mejora\n\nFormato: Markdown con bloques de código",
                'visibilidad' => 'publico',
                'etiquetas' => ['Desarrollo', 'Código'],
                'versiones' => [
                    "Como developer senior, revisa:\n\n```[LENGUAJE]\n[CÓDIGO]\n```\n\nBusca errores y mejoras básicas",
                    "Senior developer en [LENGUAJE], analiza:\n\n```[LENGUAJE]\n[CÓDIGO]\n```\n\nReporta:\n- Errores\n- Performance\n- Best practices\n- Seguridad\n\nCon ejemplos de código mejorado",
                ],
            ],
            [
                'titulo' => 'Generador de emails de marketing',
                'descripcion' => 'Crea emails efectivos para campañas de marketing',
                'contenido' => "Eres copywriter especializado en email marketing. Crea un email para: [OBJETIVO]\n\nDetalles de la campaña:\n- Audiencia: [PÚBLICO_OBJETIVO]\n- Producto/Servicio: [DESCRIPCIÓN]\n- Oferta: [OFERTA_ESPECÍFICA]\n- Tono: [PROFESIONAL/AMIGABLE/URGENTE]\n\nEstructura del email:\n1. Subject line (5 opciones A/B testing)\n2. Preheader text\n3. Saludo personalizado\n4. Introducción que conecte emocionalmente\n5. Cuerpo con beneficios (no características)\n6. CTA destacado (2 variaciones)\n7. PS con urgencia o valor adicional\n\nIncluye notas sobre dónde colocar imágenes",
                'visibilidad' => 'publico',
                'etiquetas' => ['Email', 'Marketing', 'Contenido'],
                'versiones' => [
                    "Como copywriter, crea email para: [OBJETIVO]\n\nIncluye:\n- Subject (3 opciones)\n- Cuerpo persuasivo\n- CTA\n\nAudiencia: [PÚBLICO]",
                ],
            ],
            [
                'titulo' => 'Planificador de contenido de blog',
                'descripcion' => 'Genera calendario editorial con temas y estructura',
                'contenido' => "Actúa como content strategist. Crea plan de contenido para blog sobre: [NICHO]\n\nObjetivos:\n- Target: [AUDIENCIA]\n- Keywords principales: [KEYWORDS]\n- Frecuencia: [POSTS_POR_MES] posts/mes\n- Duración: 3 meses\n\nPara cada post proporciona:\n1. Título tentativo\n2. Palabra clave principal + secundarias\n3. Estructura de H2/H3\n4. Meta descripción (150-160 caracteres)\n5. Intención de búsqueda (informacional/transaccional/navegacional)\n6. Dificultad estimada SEO (1-10)\n7. Ideas de CTAs relevantes\n\nFormato: Tabla markdown con calendario semanal",
                'visibilidad' => 'publico',
                'etiquetas' => ['Blog', 'Contenido', 'SEO', 'Marketing'],
                'versiones' => [
                    "Content strategist para [NICHO]. Plan 1 mes de blog.\n\nIncluye por post:\n- Título\n- Keyword\n- Estructura H2\n\nTabla con 4 posts",
                    "Como strategist, crea calendario editorial 3 meses sobre: [NICHO]\n\nDetalles por post:\n- Título SEO\n- Keywords\n- Estructura completa\n- Meta descripción\n- Dificultad SEO\n\nTabla semanal",
                ],
            ],
            [
                'titulo' => 'Creador de documentación técnica',
                'descripcion' => 'Genera documentación clara para APIs o librerías',
                'contenido' => "Eres technical writer especializado en [TECNOLOGÍA]. Documenta: [FUNCIÓN/API/LIBRERÍA]\n\nCódigo a documentar:\n```[LENGUAJE]\n[CÓDIGO]\n```\n\nEstructura de documentación:\n\n## Descripción\n- Qué hace\n- Cuándo usarlo\n- Cuándo NO usarlo\n\n## Sintaxis\n```\n[firma completa con tipos]\n```\n\n## Parámetros\n| Nombre | Tipo | Requerido | Default | Descripción |\n\n## Retorno\n- Tipo de dato\n- Posibles valores\n- Manejo de errores\n\n## Ejemplos\n### Básico\n### Avanzado\n### Edge cases\n\n## Notas\n- Performance considerations\n- Breaking changes\n- Deprecated alternatives\n\n## Ver también\n- Links a docs relacionadas",
                'visibilidad' => 'publico',
                'etiquetas' => ['Documentación', 'Desarrollo', 'Código'],
                'versiones' => [],
            ],
            [
                'titulo' => 'Generador de scripts para videos',
                'descripcion' => 'Crea guiones atractivos para contenido de video',
                'contenido' => "Actúa como guionista para YouTube/TikTok. Crea script para video sobre: [TEMA]\n\nDetalles:\n- Plataforma: [YOUTUBE/TIKTOK/INSTAGRAM]\n- Duración objetivo: [MINUTOS]\n- Audiencia: [DESCRIPCIÓN]\n- Estilo: [EDUCATIVO/ENTRETENIDO/TUTORIAL]\n\nEstructura del guión:\n\n**HOOK (0-5 seg)**\n[Frase impactante que enganche inmediatamente]\n\n**INTRODUCCIÓN (5-15 seg)**\n[Presentación y promesa de valor]\n\n**DESARROLLO (cuerpo principal)**\nPunto 1: [Título] (tiempo estimado)\n- Visual sugerido: \n- Texto en pantalla:\n- Narración:\n\nPunto 2: [Título] (tiempo estimado)\n...\n\n**CIERRE (últimos 10 seg)**\n- Resumen de valor\n- CTA específico\n- Despedida\n\n**NOTAS DE PRODUCCIÓN**\n- B-roll sugerido\n- Música recomendada\n- Transiciones clave",
                'visibilidad' => 'publico',
                'etiquetas' => ['Video', 'Contenido', 'Social Media'],
                'versiones' => [
                    "Guionista para [PLATAFORMA]. Script de [DURACIÓN] sobre: [TEMA]\n\nIncluye:\n- Hook\n- Desarrollo\n- CTA\n\nSimplificado",
                ],
            ],
            [
                'titulo' => 'Analizador de métricas y KPIs',
                'descripcion' => 'Interpreta datos y sugiere acciones basadas en métricas',
                'contenido' => "Como data analyst, analiza estas métricas de [CANAL/CAMPAÑA]:\n\nDatos del período [FECHA_INICIO] a [FECHA_FIN]:\n```\n[DATOS_CSV o JSON]\n```\n\nBenchmarks del sector:\n[BENCHMARKS]\n\nAnaliza:\n\n## 1. Resumen Ejecutivo\n- Top 3 hallazgos\n- Estado general (código de color)\n\n## 2. Análisis por Métrica\nPara cada KPI:\n- Tendencia (↑↓→)\n- Comparación vs período anterior (%)\n- Comparación vs benchmark\n- Insights clave\n\n## 3. Correlaciones\n- Patrones identificados\n- Anomalías\n- Causas potenciales\n\n## 4. Acciones Recomendadas\nPara cada recomendación:\n- Prioridad (Alta/Media/Baja)\n- Impacto esperado\n- Esfuerzo requerido\n- Plazo de implementación\n\n## 5. Próximos Pasos\n- Plan de acción 30 días\n- Métricas a monitorear",
                'visibilidad' => 'publico',
                'etiquetas' => ['Análisis', 'Marketing'],
                'versiones' => [],
            ],
            [
                'titulo' => 'Optimizador de landing pages',
                'descripcion' => 'Revisa y mejora landing pages para conversión',
                'contenido' => "Eres CRO specialist. Audita esta landing page:\n\nURL: [URL]\nObjetivo de conversión: [CTA_PRINCIPAL]\n\nElementos actuales:\n- Headline: [TEXTO]\n- Subheadline: [TEXTO]\n- Hero section: [DESCRIPCIÓN]\n- Benefits: [LISTA]\n- Social proof: [TIPO]\n- CTA: [TEXTO Y UBICACIÓN]\n\nAuditoría CRO:\n\n## Above the fold\n### Headline\n- Evaluación actual (1-10):\n- Problemas:\n- Mejora propuesta:\n- Razón:\n\n### Value Proposition\n- Claridad (1-10):\n- Diferenciación (1-10):\n- Mejora:\n\n## Cuerpo\n### Estructura visual\n- Jerarquía:\n- Espaciado:\n- Distracciones:\n\n### Contenido\n- Features vs Benefits:\n- Objeciones respondidas:\n- Urgencia/Escasez:\n\n### Social Proof\n- Tipo usado:\n- Efectividad (1-10):\n- Alternativas:\n\n### CTA\n- Texto actual:\n- Color/Contraste:\n- Ubicación:\n- Micro-copy:\n- Mejoras:\n\n## Recomendaciones priorizadas\n1. [Quick wins]\n2. [Medium effort]\n3. [Tests A/B sugeridos]\n\nImpacto esperado en conversión: +X%",
                'visibilidad' => 'enlace',
                'etiquetas' => ['Marketing', 'Diseño'],
                'versiones' => [
                    "CRO specialist. Audita landing:\n\nElementos:\n- Headline: [TEXTO]\n- CTA: [TEXTO]\n\nMejoras básicas para conversión",
                ],
            ],
            [
                'titulo' => 'Generador de user stories SCRUM',
                'descripcion' => 'Crea user stories bien formadas con criterios de aceptación',
                'contenido' => "Como product owner, crea user stories para: [FEATURE]\n\nContexto del proyecto:\n- Producto: [DESCRIPCIÓN]\n- Usuario tipo: [PERSONA]\n- Problema a resolver: [PROBLEMA]\n\nGenera 5-8 user stories usando formato:\n\n---\n### US-[ID]: [Título descriptivo]\n\n**Como** [tipo de usuario]\n**Quiero** [acción/funcionalidad]\n**Para** [beneficio/valor]\n\n**Prioridad:** [Alta/Media/Baja] (según [MOSCOW/VALUE vs EFFORT])\n\n**Criterios de Aceptación:**\n- [ ] Dado [contexto inicial]\n- [ ] Cuando [acción]\n- [ ] Entonces [resultado esperado]\n- [ ] Y [condiciones adicionales]\n\n**Definición de Done:**\n- [ ] Código revisado\n- [ ] Tests unitarios pasando\n- [ ] Documentación actualizada\n- [ ] QA aprobado\n- [ ] Deployado a staging\n\n**Story Points:** [FIBONACCI: 1,2,3,5,8]\n\n**Dependencias:**\n- Bloqueado por: [US-XX]\n- Bloquea: [US-YY]\n\n**Notas técnicas:**\n[Consideraciones de implementación]\n\n**Mockups/Referencias:**\n[Links o descripciones]\n\n---\n\nAl final incluye:\n- Épica padre\n- Sprint sugerido\n- Riesgos identificados",
                'visibilidad' => 'privado',
                'etiquetas' => ['Desarrollo', 'Documentación'],
                'versiones' => [],
            ],
        ];

        foreach ($prompts as $promptData) {
            $prompt = Prompt::create([
                'user_id' => $admin->id,
                'titulo' => $promptData['titulo'],
                'descripcion' => $promptData['descripcion'],
                'contenido' => $promptData['contenido'],
                'visibilidad' => $promptData['visibilidad'],
            ]);

            // Adjuntar etiquetas
            foreach ($promptData['etiquetas'] as $etiquetaNombre) {
                if (isset($etiquetas[$etiquetaNombre])) {
                    $prompt->etiquetas()->attach($etiquetas[$etiquetaNombre]->id);
                }
            }

            // Crear versiones
            foreach ($promptData['versiones'] as $index => $contenidoVersion) {
                Version::create([
                    'prompt_id' => $prompt->id,
                    'numero_version' => $index + 1,
                    'contenido' => $contenidoVersion,
                    'mensaje_cambio' => $index === 0 ? 'Versión inicial simplificada' : 'Mejora '.($index + 1).': más detalles y estructura',
                ]);
            }
        }

        $this->command->info('✅ Creados '.count($prompts).' prompts útiles con etiquetas y versiones');
    }
}
