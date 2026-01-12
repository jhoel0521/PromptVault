<?php

namespace App\Enums;

enum AiProvider: string
{
    case GROQ = 'groq';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::GROQ => 'Groq (Llama 3.3)',
        };
    }

    public function getModel(): string
    {
        return match ($this) {
            self::GROQ => 'llama-3.3-70b-versatile',
        };
    }
}
