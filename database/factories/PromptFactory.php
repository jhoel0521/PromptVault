<?php

namespace Database\Factories;

use App\Models\Prompt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prompt>
 */
class PromptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'titulo' => fake()->sentence(5),
            'descripcion' => fake()->text(200),
            'contenido' => fake()->paragraphs(3, true),
            'visibilidad' => fake()->randomElement(['privado', 'publico', 'enlace']),
            'version_actual' => 1,
            'promedio_calificacion' => fake()->numberBetween(1, 5),
            'conteo_vistas' => fake()->numberBetween(0, 1000),
        ];
    }

    /**
     * Indica que el prompt es público
     */
    public function publico(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibilidad' => 'publico',
        ]);
    }

    /**
     * Indica que el prompt es privado
     */
    public function privado(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibilidad' => 'privado',
        ]);
    }

    /**
     * Indica que el prompt es compartible por enlace
     */
    public function enlace(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibilidad' => 'enlace',
        ]);
    }

    /**
     * Indica que el prompt está inactivo
     */
    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }
}
