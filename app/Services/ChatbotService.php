<?php

namespace App\Services;

use App\Contracts\Repositories\PromptRepositoryInterface;
use App\Contracts\Services\ChatbotServiceInterface;
use App\Enums\AiProvider;
use App\Factories\ChatbotRepositoryFactory;
use App\Models\User;
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

        // Convertir paginator a collection y filtrar seguridad adicional si es necesario
        // El repositorio ya debería filtrar por user_id, pero aseguramos
        return collect($promptsPaginator->items());
    }

    /**
     * Hacer pregunta al chatbot
     */
    public function ask(User $user, string $question, ?AiProvider $provider = null): array
    {
        // Crear repositorio AI (Solo Groq por ahora)
        $aiRepo = ChatbotRepositoryFactory::getDefault();

        // Buscar prompts relevantes basados en keywords simples de la pregunta
        $keywords = $this->extractKeywords($question);
        $prompts = $this->getAvailablePrompts($user, $keywords);

        // Construir contexto
        $context = $this->buildContext($prompts);

        // Obtener respuesta de IA
        $response = $aiRepo->ask($question, $context);

        return [
            'response' => $response['response'],
            'model' => $response['model'],
            'provider' => $aiRepo->getProviderName(),
            'related_prompts' => $prompts->take(4)->values()->map(fn ($p) => [
                'id' => $p->id,
                'titulo' => $p->titulo,
                'descripcion' => Str::limit($p->descripcion, 50),
                'url' => route('prompts.show', $p),
            ]),
        ];
    }

    private function buildContext(Collection $prompts): string
    {
        if ($prompts->isEmpty()) {
            return 'No se encontraron prompts específicos relacionados en la base de datos local para esta consulta. Responde basándote en tu conocimiento general.';
        }

        $context = "IMPORTANTE: Se han encontrado los siguientes prompts en la base de datos que son RELEVANTES para la consulta del usuario. Debes listarlos o recomendarlos explícitamente al principio de tu respuesta.\n\n";
        $context .= "Lista de Prompts Disponibles:\n";

        foreach ($prompts as $prompt) {
            $context .= "- ID: {$prompt->id}\n";
            $context .= "  TÍTULO: {$prompt->titulo}\n";
            $context .= "  DESCRIPCIÓN: {$prompt->descripcion}\n";
            $context .= '  CONTENIDO: '.Str::limit($prompt->contenido, 600)."\n";
            $context .= '  URL: '.route('prompts.show', $prompt)."\n\n";
        }

        $context .= "Instrucciones: Si alguno de estos prompts es útil para la solicitud del usuario, recomiéndalo y enlaza a él. Si el usuario pide crear uno, puedes usar estos como base o inspiración.\n\n";

        return $context;
    }

    private function extractKeywords(string $question): array
    {
        // Palabras a ignorar (incluyendo errores comunes como "pront")
        $stopWords = [
            'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'y', 'o', 'pero', 'si', 'no', 'en', 'de', 'para', 'por', 'con', 'sin', 'sobre',
            'mi', 'tu', 'su', 'mis', 'tus', 'sus', 'que', 'como', 'cuando', 'donde',
            'prompts', 'prompt', 'pront', 'promt',
            'ayuda', 'necesito', 'busco', 'quiero', 'dame', 'muestrame', 'hola', 'buenos', 'dias', 'tardes', 'noches', 'explicarme', 'spanish', 'espanol',
        ];

        // Limpiar caracteres especiales
        $cleanQuestion = preg_replace('/[^\p{L}\p{N}\s]/u', '', strtolower($question));
        $words = str_word_count($cleanQuestion, 1, 'áéíóúñ');
        $keywords = array_diff($words, $stopWords);

        // Si no hay keywords útiles, devolver lista vacía
        if (empty($keywords)) {
            return [];
        }

        return array_slice($keywords, 0, 5);
    }
}
