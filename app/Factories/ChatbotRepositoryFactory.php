<?php

namespace App\Factories;

use App\Contracts\Repositories\ChatbotRepositoryInterface;
use App\Enums\AiProvider;
use App\Repositories\ChatbotClaudeRepository;
use App\Repositories\ChatbotGroqRepository;

class ChatbotRepositoryFactory
{
    /**
     * Crear instancia del repositorio según provider
     */
    public static function create(AiProvider $provider): ChatbotRepositoryInterface
    {
        return match ($provider) {
            AiProvider::GROQ => new ChatbotGroqRepository,
            AiProvider::CLAUDE => new ChatbotClaudeRepository,
        };
    }

    /**
     * Obtener provider por defecto basado en configuración
     */
    public static function getDefault(): ChatbotRepositoryInterface
    {
        $defaultProvider = config('services.chatbot.default_provider', 'groq');
        $provider = AiProvider::tryFrom($defaultProvider) ?? AiProvider::GROQ;

        return self::create($provider);
    }

    /**
     * Obtener el AiProvider por defecto
     */
    public static function getDefaultProvider(): AiProvider
    {
        $defaultProvider = config('services.chatbot.default_provider', 'groq');

        return AiProvider::tryFrom($defaultProvider) ?? AiProvider::GROQ;
    }

    /**
     * Listar providers disponibles
     */
    public static function getAvailableProviders(): array
    {
        return [
            [
                'value' => AiProvider::GROQ->value,
                'name' => AiProvider::GROQ->getDisplayName(),
            ],
            [
                'value' => AiProvider::CLAUDE->value,
                'name' => AiProvider::CLAUDE->getDisplayName(),
            ],
        ];
    }
}
