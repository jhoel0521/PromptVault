<?php

namespace App\Enums;

enum AiProvider: string
{
    case GROQ = 'groq';
    case CLAUDE = 'claude';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::GROQ => 'Groq (Llama 3.3)',
            self::CLAUDE => 'Claude (Anthropic)',
        };
    }

    public function getModel(): string
    {
        return match ($this) {
            self::GROQ => 'llama-3.3-70b-versatile',
            self::CLAUDE => 'claude-sonnet-4-20250514',
        };
    }
}
