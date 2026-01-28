<?php

namespace Tests\Unit\Models;

use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class AccesoCompartidoTest extends TestCase
{
    /**
     * Test que un acceso compartido pertenece a un usuario
     */
    public function test_acceso_compartido_pertenece_a_usuario(): void
    {
        $acceso = AccesoCompartido::factory()->create();

        $this->assertNotNull($acceso->user);
        $this->assertInstanceOf(User::class, $acceso->user);
    }

    /**
     * Test que un acceso compartido pertenece a un prompt
     */
    public function test_acceso_compartido_pertenece_a_prompt(): void
    {
        $acceso = AccesoCompartido::factory()->create();

        $this->assertNotNull($acceso->prompt);
        $this->assertInstanceOf(Prompt::class, $acceso->prompt);
    }

    /**
     * Test que el nivel de acceso se valida correctamente
     */
    public function test_acceso_compartido_nivel_acceso(): void
    {
        $acceso1 = AccesoCompartido::factory()->lector()->create();
        $acceso2 = AccesoCompartido::factory()->comentador()->create();
        $acceso3 = AccesoCompartido::factory()->editor()->create();

        $this->assertEquals('lector', $acceso1->nivel_acceso);
        $this->assertEquals('comentador', $acceso2->nivel_acceso);
        $this->assertEquals('editor', $acceso3->nivel_acceso);
    }
}
