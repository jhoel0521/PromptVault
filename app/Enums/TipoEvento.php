<?php

namespace App\Enums;

enum TipoEvento: string
{
    case TRABAJO = 'trabajo';
    case PERSONAL = 'personal';
    case ESTUDIO = 'estudio';
    case RECORDATORIO = 'recordatorio';
    case REUNION = 'reunion';
    case TAREA = 'tarea';
    case OTRO = 'otro';

    /**
     * Obtener el label para mostrar en UI
     */
    public function label(): string
    {
        return match ($this) {
            self::TRABAJO => 'Trabajo',
            self::PERSONAL => 'Personal',
            self::ESTUDIO => 'Estudio',
            self::RECORDATORIO => 'Recordatorio',
            self::REUNION => 'Reunión',
            self::TAREA => 'Tarea',
            self::OTRO => 'Otro',
        };
    }

    /**
     * Obtener el color para el calendario
     */
    public function color(): string
    {
        return match ($this) {
            self::TRABAJO => '#ef4444',      // red
            self::PERSONAL => '#3b82f6',     // blue
            self::ESTUDIO => '#10b981',      // green
            self::RECORDATORIO => '#f59e0b', // amber
            self::REUNION => '#8b5cf6',      // violet
            self::TAREA => '#ec4899',        // pink
            self::OTRO => '#6b7280',         // gray
        };
    }

    /**
     * Obtener clases de Tailwind para badges
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::TRABAJO => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
            self::PERSONAL => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
            self::ESTUDIO => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
            self::RECORDATORIO => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
            self::REUNION => 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300',
            self::TAREA => 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300',
            self::OTRO => 'bg-slate-100 dark:bg-slate-900/30 text-slate-700 dark:text-slate-300',
        };
    }

    /**
     * Obtener todos los valores como array para selects
     */
    public static function toArray(): array
    {
        return array_map(
            fn (self $tipo) => [
                'value' => $tipo->value,
                'label' => $tipo->label(),
                'color' => $tipo->color(),
            ],
            self::cases()
        );
    }
}
