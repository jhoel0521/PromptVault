<?php

namespace App\Enums;

enum AiProvider: string
{
    case GROQ = 'groq';
    case CLAUDE = 'claude';
    case GEMINI = 'gemini';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::GROQ => 'Groq (Llama 3.3)',
            self::CLAUDE => 'Claude (Anthropic)',
            self::GEMINI => 'Gemini (Google AI Studio)',
        };
    }

    public function getModel(): string
    {
        return match ($this) {
            self::GROQ => 'llama-3.3-70b-versatile',
            self::CLAUDE => 'claude-sonnet-4-20250514',
            self::GEMINI => 'gemini-2.0-flash',
        };
    }
}
