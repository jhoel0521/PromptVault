<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatbotRepositoryInterface;
use Illuminate\Support\Facades\Http;

class ChatbotGeminiRepository implements ChatbotRepositoryInterface
{
    private string $apiKey;

    private string $model;

    private string $apiBaseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash');
    }

    public function ask(string $question, string $context): array
    {
        if (! $this->isAvailable()) {
            return [
                'response' => "**Configuracion incompleta**: No se ha configurado la API Key de Google AI Studio.\n\nPor favor agrega `GOOGLE_AI_STUDIO_API_KEY=AIza...` en tu archivo `.env`.",
                'model' => 'none',
            ];
        }

        try {
            $payload = [
                'systemInstruction' => [
                    'parts' => [
                        [
                            'text' => 'Eres un asistente experto en ingeniería de prompts para PromptVault.

REGLAS IMPORTANTES:
1. SOLO menciona prompts que aparezcan EXPLÍCITAMENTE en el contexto proporcionado.
2. NUNCA inventes prompts, IDs o URLs que no estén en el contexto.
3. Si el contexto indica que no hay prompts relevantes, NO menciones ningún prompt.
4. Si hay prompts en el contexto, solo recomiéndalos si son REALMENTE útiles para la pregunta.
5. Responde de forma concisa y útil.
6. Puedes ayudar con preguntas generales sobre ingeniería de prompts aunque no haya prompts en el contexto.',
                        ],
                    ],
                ],
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            [
                                'text' => "Contexto de Prompts Disponibles:\n{$context}\n\nPregunta del Usuario: {$question}",
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1024,
                ],
            ];

            $response = Http::timeout(60)->post(
                $this->apiBaseUrl.$this->model.':generateContent?key='.$this->apiKey,
                $payload
            );

            if ($response->failed()) {
                $error = $response->json('error.message', 'Error desconocido');

                return [
                    'response' => "**Error de API**: {$error}",
                    'model' => $this->model,
                ];
            }

            $text = $response->json('candidates.0.content.parts.0.text', 'Sin respuesta');

            return [
                'response' => $text,
                'model' => $this->model,
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
        return 'Gemini';
    }
}
