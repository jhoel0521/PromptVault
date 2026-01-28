<?php

namespace Database\Factories;

use App\Models\Prompt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Version>
 */
class VersionFactory extends Factory
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
            'numero_version' => fake()->numberBetween(1, 10),
            'contenido' => fake()->paragraphs(3, true),
            'mensaje_cambio' => fake()->optional()->sentence(),
        ];
    }
}
