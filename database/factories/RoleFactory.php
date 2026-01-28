<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->word(),
            'descripcion' => fake()->sentence(),
            'nivel_acceso' => fake()->numberBetween(1, 5),
        ];
    }

    /**
     * Crear rol Admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'Administrador',
            'descripcion' => 'Acceso total al sistema',
        ]);
    }

    /**
     * Crear rol User (usuario regular)
     */
    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'Usuario',
            'descripcion' => 'Acceso básico como usuario regular',
        ]);
    }

    /**
     * Crear rol Editor
     */
    public function editor(): static
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'Editor',
            'descripcion' => 'Puede editar contenido',
        ]);
    }
}
