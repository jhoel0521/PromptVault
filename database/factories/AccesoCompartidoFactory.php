<?php

namespace Database\Factories;

use App\Models\Prompt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccesoCompartido>
 */
class AccesoCompartidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prompt_id' => Prompt::factory(),
            'user_id' => User::factory(),
            'nivel_acceso' => fake()->randomElement(['lector', 'comentador', 'editor']),
            'fecha_expiracion' => fake()->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }

    /**
     * Crear acceso como lector
     */
    public function lector(): static
    {
        return $this->state(fn (array $attributes) => [
            'nivel_acceso' => 'lector',
        ]);
    }

    /**
     * Crear acceso como comentador
     */
    public function comentador(): static
    {
        return $this->state(fn (array $attributes) => [
            'nivel_acceso' => 'comentador',
        ]);
    }

    /**
     * Crear acceso como editor
     */
    public function editor(): static
    {
        return $this->state(fn (array $attributes) => [
            'nivel_acceso' => 'editor',
        ]);
    }
}
