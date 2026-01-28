<?php

namespace App\Services;

use App\Contracts\Repositories\PromptRepositoryInterface;
use App\Contracts\Services\ChatbotServiceInterface;
use App\Enums\AiProvider;
use App\Factories\ChatbotRepositoryFactory;
use App\Models\ChatbotConversacion;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ChatbotService implements ChatbotServiceInterface
{
    public function __construct(
        private PromptRepositoryInterface $promptRepository
    ) {}

    /**
     * Obtener prompts disponibles para el usuario
     *
     * @param  string|array|null  $keywords
     */
    public function getAvailablePrompts(User $user, $keywords = null): Collection
    {
        // Si no hay keywords, no buscar prompts (evita mostrar prompts aleatorios)
        if (empty($keywords)) {
            return collect();
        }

        $filters = [];

        if (is_array($keywords)) {
            $filters['any_keywords'] = $keywords;
        } elseif (is_string($keywords)) {
            $filters['buscar'] = $keywords;
        }

        // Usar la firma correcta: getPrompts(?int $userId, int $perPage, array $filters)
        $promptsPaginator = $this->promptRepository->getPrompts(
            $user->id,
            10, // Limit
            $filters
        );

        return collect($promptsPaginator->items());
    }

    /**
     * Hacer pregunta al chatbot
     */
    public function ask(User $user, string $question, ?AiProvider $provider = null): array
    {
        // Usar provider especificado o el default de configuración
        $provider = $provider ?? ChatbotRepositoryFactory::getDefaultProvider();
        $aiRepo = ChatbotRepositoryFactory::create($provider);

        // Buscar prompts relevantes basados en keywords simples de la pregunta
        $keywords = $this->extractKeywords($question);
        $prompts = $this->getAvailablePrompts($user, $keywords);

        // Construir contexto
        $context = $this->buildContext($prompts);

        // Obtener respuesta de IA
        $response = $aiRepo->ask($question, $context);

        // Preparar datos de prompts relacionados
        $relatedPrompts = $prompts->take(4)->values()->map(fn ($p) => [
            'id' => $p->id,
            'titulo' => $p->titulo,
            'descripcion' => Str::limit($p->descripcion, 50),
            'url' => route('prompts.show', $p),
        ])->toArray();

        // Persistir conversacion
        ChatbotConversacion::create([
            'user_id' => $user->id,
            'question' => $question,
            'response' => $response['response'],
            'provider' => strtolower($aiRepo->getProviderName()),
            'model' => $response['model'],
            'related_prompts' => $relatedPrompts,
        ]);

        return [
            'response' => $response['response'],
            'model' => $response['model'],
            'provider' => $aiRepo->getProviderName(),
            'related_prompts' => $relatedPrompts,
        ];
    }

    /**
     * Obtener historial de conversaciones del usuario
     */
    public function getHistory(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return ChatbotConversacion::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Eliminar una conversacion del historial
     */
    public function deleteConversation(User $user, int $conversationId): bool
    {
        return ChatbotConversacion::where('user_id', $user->id)
            ->where('id', $conversationId)
            ->delete() > 0;
    }

    /**
     * Limpiar todo el historial del usuario
     */
    public function clearHistory(User $user): int
    {
        return ChatbotConversacion::where('user_id', $user->id)->delete();
    }

    private function buildContext(Collection $prompts): string
    {
        if ($prompts->isEmpty()) {
            return "IMPORTANTE: No se encontraron prompts en la base de datos del usuario relacionados con esta consulta.\n\n".
                   "Instrucciones:\n".
                   "- NO inventes ni sugieras prompts que no existen.\n".
                   "- NO menciones IDs de prompts ni URLs.\n".
                   "- Responde la pregunta del usuario basándote en tu conocimiento general sobre ingeniería de prompts.\n".
                   '- Si el usuario pregunta por prompts específicos, indícale que no se encontraron coincidencias y que puede buscar en su biblioteca o crear uno nuevo.';
        }

        $context = "Se encontraron los siguientes prompts en la base de datos que podrían ser relevantes:\n\n";

        foreach ($prompts as $prompt) {
            $context .= "---\n";
            $context .= "TÍTULO: {$prompt->titulo}\n";
            $context .= 'DESCRIPCIÓN: '.($prompt->descripcion ?: 'Sin descripción')."\n";
            $context .= 'CONTENIDO (extracto): '.Str::limit($prompt->contenido, 400)."\n";
            $context .= 'URL: '.route('prompts.show', $prompt)."\n\n";
        }

        $context .= "---\n";
        $context .= "Instrucciones:\n";
        $context .= "- SOLO recomienda estos prompts si son REALMENTE relevantes para la pregunta del usuario.\n";
        $context .= "- Si ninguno es relevante, responde la pregunta sin mencionar prompts.\n";
        $context .= "- NO inventes prompts que no están en esta lista.\n";

        return $context;
    }

    private function extractKeywords(string $question): array
    {
        // Palabras a ignorar (stopwords en español + términos comunes del chatbot)
        $stopWords = [
            // Artículos y preposiciones
            'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'al', 'del',
            'y', 'o', 'pero', 'si', 'no', 'en', 'de', 'para', 'por', 'con', 'sin', 'sobre', 'entre', 'hacia', 'desde', 'hasta',
            // Pronombres
            'mi', 'tu', 'su', 'mis', 'tus', 'sus', 'yo', 'me', 'te', 'se', 'nos', 'les', 'lo', 'le', 'este', 'esta', 'esto', 'ese', 'esa', 'eso',
            // Interrogativos y relativos
            'que', 'como', 'cómo', 'cuando', 'cuándo', 'donde', 'dónde', 'cual', 'cuál', 'cuales', 'cuáles', 'quien', 'quién',
            // Verbos auxiliares y comunes
            'es', 'son', 'ser', 'estar', 'hay', 'tiene', 'tienen', 'tener', 'hacer', 'poder', 'puedo', 'puede', 'pueden', 'debo', 'debe',
            // Palabras relacionadas con prompts (evitar buscar por estas)
            'prompts', 'prompt', 'pront', 'promt', 'promptvault',
            // Palabras de cortesía y solicitud
            'ayuda', 'necesito', 'busco', 'quiero', 'dame', 'muestrame', 'muéstrame', 'dime', 'explicame', 'explícame', 'explicarme',
            'hola', 'buenos', 'dias', 'días', 'tardes', 'noches', 'gracias', 'favor', 'porfa', 'porfavor',
            // Palabras genéricas
            'algo', 'cosa', 'cosas', 'tipo', 'tipos', 'manera', 'forma', 'ejemplo', 'ejemplos',
            'mejor', 'mejores', 'bueno', 'buenos', 'buena', 'buenas', 'nuevo', 'nueva', 'nuevos', 'nuevas',
            'usar', 'uso', 'utilizar', 'crear', 'generar', 'hacer', 'obtener', 'conseguir',
            'spanish', 'espanol', 'español', 'ingles', 'inglés', 'english',
            // Conectores
            'también', 'además', 'entonces', 'luego', 'después', 'antes', 'ahora', 'aquí', 'allí',
        ];

        // Limpiar caracteres especiales y convertir a minúsculas
        $cleanQuestion = preg_replace('/[^\p{L}\p{N}\s]/u', '', mb_strtolower($question));
        $words = preg_split('/\s+/', $cleanQuestion, -1, PREG_SPLIT_NO_EMPTY);

        // Filtrar stopwords y palabras muy cortas (menos de 3 caracteres)
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return mb_strlen($word) >= 3 && ! in_array($word, $stopWords);
        });

        // Si no hay keywords útiles, devolver lista vacía
        if (empty($keywords)) {
            return [];
        }

        // Devolver máximo 5 keywords, priorizando las más largas (más específicas)
        $keywords = array_values($keywords);
        usort($keywords, fn ($a, $b) => mb_strlen($b) - mb_strlen($a));

        return array_slice($keywords, 0, 5);
    }
}
