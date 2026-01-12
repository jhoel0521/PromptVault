<?php

namespace App\Contracts\Repositories;

interface ChatbotRepositoryInterface
{
    /**
     * Enviar pregunta al AI provider
     *
     * @param  string  $question  Pregunta del usuario
     * @param  string  $context  Contexto de prompts disponibles
     * @return array ['response' => string, 'model' => string]
     */
    public function ask(string $question, string $context): array;

    /**
     * Verificar si el provider está disponible
     */
    public function isAvailable(): bool;

    /**
     * Obtener nombre del provider
     */
    public function getProviderName(): string;
}
