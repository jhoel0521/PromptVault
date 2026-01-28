<?php

namespace Tests\Unit\Services;

use App\Models\Calificacion;
use App\Models\Prompt;
use App\Models\User;
use App\Services\CalificacionService;
use Tests\TestCase;

class CalificacionServiceTest extends TestCase
{
    private CalificacionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(CalificacionService::class);
    }

    /**
     * Test que calificar crea o actualiza calificación
     */
    public function test_calificar_creates_or_updates_rating(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create();

        // Primera calificación
        $calificacion = $this->service->calificar($prompt, $user, [
            'estrellas' => 5,
            'resena' => 'Excelente prompt',
        ]);

        $this->assertInstanceOf(Calificacion::class, $calificacion);
        $this->assertEquals(5, $calificacion->estrellas);
        $this->assertEquals('Excelente prompt', $calificacion->resena);
        $this->assertEquals($prompt->id, $calificacion->prompt_id);
        $this->assertEquals($user->id, $calificacion->user_id);

        // Actualizar calificación existente
        $calificacionActualizada = $this->service->calificar($prompt, $user, [
            'estrellas' => 3,
            'resena' => 'Regular',
        ]);

        $this->assertEquals($calificacion->id, $calificacionActualizada->id);
        $this->assertEquals(3, $calificacionActualizada->estrellas);
        $this->assertEquals('Regular', $calificacionActualizada->resena);

        // Validar que solo existe una calificación
        $this->assertEquals(1, Calificacion::where('prompt_id', $prompt->id)
            ->where('user_id', $user->id)
            ->count());
    }

    /**
     * Test que obtener calificación devuelve la calificación del usuario
     */
    public function test_obtener_calificacion_returns_user_rating(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $prompt = Prompt::factory()->create();

        // Crear calificación del usuario
        $calificacion = Calificacion::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user->id,
            'estrellas' => 4,
            'resena' => 'Muy bueno',
        ]);

        // Crear calificación de otro usuario
        Calificacion::create([
            'prompt_id' => $prompt->id,
            'user_id' => $otherUser->id,
            'estrellas' => 2,
            'resena' => 'No me gustó',
        ]);

        // Obtener calificación del usuario
        $resultado = $this->service->obtenerCalificacion($prompt, $user);

        $this->assertInstanceOf(Calificacion::class, $resultado);
        $this->assertEquals($calificacion->id, $resultado->id);
        $this->assertEquals(4, $resultado->estrellas);
        $this->assertEquals('Muy bueno', $resultado->resena);

        // Validar que no devuelve calificación de otro usuario
        $this->assertNotEquals($otherUser->id, $resultado->user_id);

        // Validar que devuelve null si no hay calificación
        $userSinCalificacion = User::factory()->create();
        $resultadoNull = $this->service->obtenerCalificacion($prompt, $userSinCalificacion);
        $this->assertNull($resultadoNull);
    }
}
