<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatbotRepositoryInterface;
use LucianoTonet\GroqPHP\Groq;
use LucianoTonet\GroqPHP\GroqException;

class ChatbotGroqRepository implements ChatbotRepositoryInterface
{
    private Groq $client;

    private string $model;

    public function __construct()
    {
        $apiKey = config('services.groq.api_key');
        if ($apiKey) {
            $this->client = new Groq($apiKey);
        }
        $this->model = config('services.groq.model', 'llama-3.3-70b-versatile');
    }

    public function ask(string $question, string $context): array
    {
        if (! $this->isAvailable()) {
            // No lanzar excepción, retornar respuesta amigable
            return [
                'response' => "⚠️ **Configuración incompleta**: No se ha configurado la API Key de Groq. \n\nPor favor agrega `GROQ_API_KEY=gsk_...` en tu archivo `.env`.",
                'model' => 'none',
            ];
        }

        try {
            $response = $this->client->chat()->completions()->create([
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Eres un asistente experto en ingeniería de prompts para PromptVault.

REGLAS IMPORTANTES:
1. SOLO menciona prompts que aparezcan EXPLÍCITAMENTE en el contexto proporcionado.
2. NUNCA inventes prompts, IDs o URLs que no estén en el contexto.
3. Si el contexto indica que no hay prompts relevantes, NO menciones ningún prompt.
4. Si hay prompts en el contexto, solo recomiéndalos si son REALMENTE útiles para la pregunta.
5. Responde de forma concisa y útil.
6. Puedes ayudar con preguntas generales sobre ingeniería de prompts aunque no haya prompts en el contexto.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Contexto de Prompts Disponibles:\n{$context}\n\nPregunta del Usuario: {$question}",
                    ],
                ],
                'temperature' => 0.7,
                'max_completion_tokens' => 1024,
            ]);

            return [
                'response' => $response['choices'][0]['message']['content'],
                'model' => $this->model,
            ];
        } catch (GroqException $e) {
            throw new \Exception('Groq Error: '.$e->getMessage());
        }
    }

    public function isAvailable(): bool
    {
        return ! empty(config('services.groq.api_key'));
    }

    public function getProviderName(): string
    {
        return 'Groq';
    }
}
