<?php

namespace Tests\Unit\Models;

use App\Models\Calificacion;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class CalificacionTest extends TestCase
{
    /**
     * Test que una calificación pertenece a un prompt
     */
    public function test_calificacion_pertenece_a_prompt(): void
    {
        $calificacion = Calificacion::factory()->create();

        $this->assertNotNull($calificacion->prompt);
        $this->assertInstanceOf(Prompt::class, $calificacion->prompt);
    }

    /**
     * Test que una calificación pertenece a un usuario
     */
    public function test_calificacion_pertenece_a_usuario(): void
    {
        $calificacion = Calificacion::factory()->create();

        $this->assertNotNull($calificacion->user);
        $this->assertInstanceOf(User::class, $calificacion->user);
    }

    /**
     * Test que las estrellas están en el rango 1-5
     */
    public function test_calificacion_rango_estrellas(): void
    {
        $calificacion1 = Calificacion::factory()->fiveStars()->create();
        $calificacion2 = Calificacion::factory()->oneStar()->create();

        $this->assertEquals(5, $calificacion1->estrellas);
        $this->assertEquals(1, $calificacion2->estrellas);
        $this->assertGreaterThanOrEqual(1, $calificacion1->estrellas);
        $this->assertLessThanOrEqual(5, $calificacion1->estrellas);
    }
}
