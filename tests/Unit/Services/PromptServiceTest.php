<?php

namespace Tests\Unit\Services;

use App\Models\Etiqueta;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use App\Services\PromptService;
use Tests\TestCase;

class PromptServiceTest extends TestCase
{
    private PromptService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(PromptService::class);
    }

    /**
     * Test que crear prompt valida y crea registro con versión inicial
     */
    public function test_create_prompt_validates_input(): void
    {
        $user = User::factory()->create();
        $etiqueta1 = Etiqueta::create(['nombre' => 'Laravel']);
        $etiqueta2 = Etiqueta::create(['nombre' => 'PHP']);

        $data = [
            'titulo' => 'Prompt de prueba',
            'contenido' => 'Este es el contenido del prompt',
            'descripcion' => 'Una descripción',
            'visibilidad' => 'publico',
            'etiquetas' => [$etiqueta1->id, $etiqueta2->id],
        ];

        $prompt = $this->service->crear($user, $data);

        // Validar prompt creado
        $this->assertInstanceOf(Prompt::class, $prompt);
        $this->assertEquals('Prompt de prueba', $prompt->titulo);
        $this->assertEquals('Este es el contenido del prompt', $prompt->contenido);
        $this->assertEquals('Una descripción', $prompt->descripcion);
        $this->assertEquals('publico', $prompt->visibilidad);
        $this->assertEquals(1, $prompt->version_actual);
        $this->assertEquals($user->id, $prompt->user_id);

        // Validar versión inicial creada
        $this->assertDatabaseHas('versiones', [
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => 'Este es el contenido del prompt',
            'mensaje_cambio' => 'Versión inicial',
        ]);

        // Validar etiquetas sincronizadas
        $this->assertCount(2, $prompt->etiquetas);
        $this->assertTrue($prompt->etiquetas->contains('id', $etiqueta1->id));
        $this->assertTrue($prompt->etiquetas->contains('id', $etiqueta2->id));
    }

    /**
     * Test que actualizar prompt crea nueva versión si contenido cambia
     */
    public function test_update_prompt_creates_version(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'contenido' => 'Contenido original',
            'version_actual' => 1,
        ]);

        // Crear versión inicial
        Version::create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => 'Contenido original',
            'mensaje_cambio' => 'Versión inicial',
        ]);

        // Actualizar con nuevo contenido
        $dataConCambio = [
            'titulo' => $prompt->titulo,
            'contenido' => 'Contenido actualizado',
            'mensaje_cambio' => 'Actualización importante',
        ];

        $promptActualizado = $this->service->actualizar($prompt, $dataConCambio);

        $promptActualizado->refresh();
        $this->assertEquals('Contenido actualizado', $promptActualizado->contenido);
        $this->assertEquals(2, $promptActualizado->version_actual);

        // Validar que se creó nueva versión
        $this->assertDatabaseHas('versiones', [
            'prompt_id' => $prompt->id,
            'numero_version' => 2,
            'contenido' => 'Contenido actualizado',
            'mensaje_cambio' => 'Actualización importante',
        ]);

        // Actualizar sin cambiar contenido
        $dataSinCambio = [
            'titulo' => 'Título modificado',
            'contenido' => 'Contenido actualizado', // Mismo contenido
        ];

        $promptSinVersion = $this->service->actualizar($promptActualizado, $dataSinCambio);

        $promptSinVersion->refresh();
        $this->assertEquals('Título modificado', $promptSinVersion->titulo);
        $this->assertEquals(2, $promptSinVersion->version_actual); // No incrementa

        // Validar que NO se creó versión 3
        $this->assertDatabaseMissing('versiones', [
            'prompt_id' => $prompt->id,
            'numero_version' => 3,
        ]);
    }

    /**
     * Test que eliminar prompt elimina el registro
     */
    public function test_delete_prompt_soft_delete(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id]);

        // Verificar que existe
        $this->assertDatabaseHas('prompts', [
            'id' => $prompt->id,
        ]);

        // Eliminar
        $resultado = $this->service->eliminar($prompt);

        $this->assertTrue($resultado);

        // Validar que el registro fue eliminado completamente
        $this->assertDatabaseMissing('prompts', [
            'id' => $prompt->id,
        ]);

        // Validar que no aparece en queries normales
        $this->assertNull(Prompt::find($prompt->id));
    }
}
