<?php

namespace App\Contracts\Services;

use App\Enums\AiProvider;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ChatbotServiceInterface
{
    public function ask(User $user, string $question, ?AiProvider $provider = null): array;

    /**
     * @param  string|array|null  $keywords
     */
    public function getAvailablePrompts(User $user, $keywords = null): Collection;

    public function getHistory(User $user, int $perPage = 10): LengthAwarePaginator;

    public function deleteConversation(User $user, int $conversationId): bool;

    public function clearHistory(User $user): int;

    /**
     * Listar modelos disponibles del provider
     *
     * @return array{success: bool, message: string|null, rows: array<int, array{model: string, name: string, methods: string}>}
     */
    public function getAvailableModels(AiProvider $provider): array;
}
