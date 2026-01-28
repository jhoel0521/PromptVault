<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatbotRepositoryInterface;
use Illuminate\Support\Facades\Http;

class ChatbotClaudeRepository implements ChatbotRepositoryInterface
{
    private string $apiKey;

    private string $model;

    private string $apiUrl = 'https://api.anthropic.com/v1/messages';

    public function __construct()
    {
        $this->apiKey = config('services.claude.api_key', '');
        $this->model = config('services.claude.model', 'claude-sonnet-4-20250514');
    }

    public function ask(string $question, string $context): array
    {
        if (! $this->isAvailable()) {
            return [
                'response' => "**Configuracion incompleta**: No se ha configurado la API Key de Claude. \n\nPor favor agrega `ANTHROPIC_API_KEY=sk-ant-...` en tu archivo `.env`.",
                'model' => 'none',
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->timeout(60)->post($this->apiUrl, [
                'model' => $this->model,
                'max_tokens' => 1024,
                'system' => 'Eres un asistente experto en ingeniería de prompts para PromptVault.

REGLAS IMPORTANTES:
1. SOLO menciona prompts que aparezcan EXPLÍCITAMENTE en el contexto proporcionado.
2. NUNCA inventes prompts, IDs o URLs que no estén en el contexto.
3. Si el contexto indica que no hay prompts relevantes, NO menciones ningún prompt.
4. Si hay prompts en el contexto, solo recomiéndalos si son REALMENTE útiles para la pregunta.
5. Responde de forma concisa y útil.
6. Puedes ayudar con preguntas generales sobre ingeniería de prompts aunque no haya prompts en el contexto.',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Contexto de Prompts Disponibles:\n{$context}\n\nPregunta del Usuario: {$question}",
                    ],
                ],
            ]);

            if ($response->failed()) {
                $error = $response->json('error.message', 'Error desconocido');

                return [
                    'response' => "**Error de API**: {$error}",
                    'model' => $this->model,
                ];
            }

            $data = $response->json();
            $content = $data['content'][0]['text'] ?? 'Sin respuesta';

            return [
                'response' => $content,
                'model' => $data['model'] ?? $this->model,
            ];
        } catch (\Exception $e) {
            return [
                'response' => '**Error de conexion**: '.$e->getMessage(),
                'model' => $this->model,
            ];
        }
    }

    public function isAvailable(): bool
    {
        return ! empty($this->apiKey);
    }

    public function getProviderName(): string
    {
        return 'Claude';
    }
}
