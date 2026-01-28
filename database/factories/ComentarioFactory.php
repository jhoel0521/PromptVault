<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
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
            'contenido' => fake()->sentence(10),
            'parent_id' => null,
        ];
    }

    /**
     * Crear un comentario como respuesta a otro comentario
     */
    public function reply(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => Comentario::factory(),
        ]);
    }
}
