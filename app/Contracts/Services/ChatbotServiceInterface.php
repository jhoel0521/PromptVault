<?php

namespace App\Contracts\Services;

use App\Enums\AiProvider;
use App\Models\User;
use Illuminate\Support\Collection;

interface ChatbotServiceInterface
{
    public function ask(User $user, string $question, ?AiProvider $provider = null): array;

    public function getAvailablePrompts(User $user, ?string $keyword = null): Collection;
}
