<?php

namespace App\Factories;

use App\Contracts\Repositories\ChatbotRepositoryInterface;
use App\Enums\AiProvider;
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
        };
    }

    /**
     * Obtener provider por defecto
     */
    public static function getDefault(): ChatbotRepositoryInterface
    {
        return new ChatbotGroqRepository;
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
        ];
    }
}
