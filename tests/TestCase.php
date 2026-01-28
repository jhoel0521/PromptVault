<?php

namespace Tests;

use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutar migraciones antes de cada test
        $this->artisan('migrate:fresh', ['--seed' => false])->run();

        // Crear roles por defecto si no existen
        Role::firstOrCreate(['id' => 1], ['nombre' => 'Administrador', 'descripcion' => 'Rol de administrador']);
        Role::firstOrCreate(['id' => 2], ['nombre' => 'Usuario', 'descripcion' => 'Rol de usuario regular']);
    }
}
