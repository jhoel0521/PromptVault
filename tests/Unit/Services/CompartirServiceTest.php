<?php

namespace Tests\Unit\Services;

use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;
use App\Services\CompartirService;
use Tests\TestCase;

class CompartirServiceTest extends TestCase
{
    private CompartirService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(CompartirService::class);
    }

    /**
     * Test que compartir crea registro de AccesoCompartido
     */
    public function test_compartir_crea_acceso_compartido(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        // Compartir con nivel lector
        $acceso = $this->service->compartir($prompt, $user, 'lector');

        $this->assertInstanceOf(AccesoCompartido::class, $acceso);
        $this->assertEquals($prompt->id, $acceso->prompt_id);
        $this->assertEquals($user->id, $acceso->user_id);
        $this->assertEquals('lector', $acceso->nivel_acceso);

        $this->assertDatabaseHas('accesos_compartidos', [
            'prompt_id' => $prompt->id,
            'user_id' => $user->id,
            'nivel_acceso' => 'lector',
        ]);

        // Actualizar nivel de acceso existente
        $accesoActualizado = $this->service->compartir($prompt, $user, 'editor');

        $this->assertEquals($acceso->id, $accesoActualizado->id);
        $this->assertEquals('editor', $accesoActualizado->nivel_acceso);

        // Validar que solo existe un registro
        $this->assertEquals(1, AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $user->id)
            ->count());
    }

    /**
     * Test que compartir por email envía notificación o retorna error
     */
    public function test_compartir_por_email_envia_notificacion(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create(['email' => 'colaborador@example.com']);
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        // Compartir con usuario existente
        $resultado = $this->service->compartirPorEmail($prompt, 'colaborador@example.com', 'comentador');

        $this->assertTrue($resultado['success']);
        $this->assertEquals("Prompt compartido con {$user->name}", $resultado['message']);
        $this->assertInstanceOf(AccesoCompartido::class, $resultado['acceso']);
        $this->assertEquals('comentador', $resultado['acceso']->nivel_acceso);

        // Intentar compartir con email inexistente
        $resultadoError = $this->service->compartirPorEmail($prompt, 'noexiste@example.com', 'lector');

        $this->assertFalse($resultadoError['success']);
        $this->assertEquals('Usuario no encontrado', $resultadoError['message']);
        $this->assertNull($resultadoError['acceso']);

        // Intentar compartir con el propietario
        $resultadoOwner = $this->service->compartirPorEmail($prompt, $owner->email, 'editor');

        $this->assertFalse($resultadoOwner['success']);
        $this->assertEquals('No puedes compartir contigo mismo', $resultadoOwner['message']);
        $this->assertNull($resultadoOwner['acceso']);
    }

    /**
     * Test que revocar acceso elimina el registro
     */
    public function test_revocar_acceso_elimina_registro(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        // Crear acceso compartido
        $acceso = AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user->id,
            'nivel_acceso' => 'lector',
        ]);

        // Verificar que existe
        $this->assertDatabaseHas('accesos_compartidos', [
            'id' => $acceso->id,
        ]);

        // Revocar acceso
        $resultado = $this->service->quitarAcceso($prompt, $user);

        $this->assertTrue($resultado);
        $this->assertDatabaseMissing('accesos_compartidos', [
            'prompt_id' => $prompt->id,
            'user_id' => $user->id,
        ]);

        // Intentar revocar acceso inexistente
        $resultadoFalso = $this->service->quitarAcceso($prompt, $user);
        $this->assertFalse($resultadoFalso);
    }
}
