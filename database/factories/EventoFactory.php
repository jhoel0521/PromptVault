<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');

        return [
            'user_id' => User::factory(),
            'titulo' => fake()->sentence(5),
            'descripcion' => fake()->text(200),
            'fecha_inicio' => $startDate,
            'fecha_fin' => fake()->dateTimeBetween($startDate, '+2 months'),
            'completado' => false,
        ];
    }

    /**
     * Crear un evento completado
     */
    public function completado(): static
    {
        return $this->state(fn (array $attributes) => [
            'completado' => true,
        ]);
    }

    /**
     * Crear un evento pendiente (incompleto)
     */
    public function pendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'completado' => false,
        ]);
    }
}
