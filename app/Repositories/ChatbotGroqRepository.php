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
                        'content' => 'Eres un asistente experto en ingeniería de prompts. 
                                     Tu objetivo es ayudar al usuario a encontrar el prompt ideal entre los disponibles en el contexto.
                                     
                                     Analiza los prompts proporcionados en el contexto y responde la pregunta del usuario.
                                     Si encuentras prompts relevantes en el contexto, menciónalos explícitamente por su título.
                                     Si la pregunta no está relacionada con los prompts, responde amablemente que solo puedes ayudar con los prompts disponibles.',
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
