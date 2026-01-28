<?php

namespace Tests\Feature\Prompts;

use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Tests\TestCase;

class PromptVersioningTest extends TestCase
{
    /**
     * Test que editar un prompt crea una nueva versión
     */
    public function test_editing_prompt_creates_new_version(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'contenido' => 'Contenido original',
            'version_actual' => 1,
        ]);

        // Crear versión inicial
        Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => 'Contenido original',
        ]);

        // Editar el prompt
        $this->actingAs($user)->put(route('prompts.update', $prompt), [
            'titulo' => $prompt->titulo,
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Contenido modificado',
            'visibilidad' => $prompt->visibilidad,
        ]);

        // Refresh del modelo
        $prompt->refresh();

        // Validar que version_actual incrementó
        $this->assertEquals(2, $prompt->version_actual);

        // Validar que existen 2 versiones en BD
        $this->assertCount(2, $prompt->versiones);

        // Validar que la nueva versión tiene el contenido modificado
        $nuevaVersion = Version::where('prompt_id', $prompt->id)
            ->where('numero_version', 2)
            ->first();

        $this->assertNotNull($nuevaVersion);
        $this->assertEquals('Contenido modificado', $nuevaVersion->contenido);
    }

    /**
     * Test que editar sin cambiar contenido NO crea nueva versión
     */
    public function test_editing_without_content_change_does_not_create_version(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'contenido' => 'Contenido original',
            'version_actual' => 1,
        ]);

        Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => 'Contenido original',
        ]);

        // Editar solo el título
        $this->actingAs($user)->put(route('prompts.update', $prompt), [
            'titulo' => 'Nuevo título',
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Contenido original', // Sin cambios
            'visibilidad' => $prompt->visibilidad,
        ]);

        $prompt->refresh();

        // version_actual debe seguir siendo 1
        $this->assertEquals(1, $prompt->version_actual);

        // Solo debe existir 1 versión
        $this->assertCount(1, $prompt->versiones);
    }

    /**
     * Test que usuario puede ver historial de versiones
     */
    public function test_user_can_view_version_history(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'version_actual' => 3,
        ]);

        // Crear 3 versiones
        Version::factory()->count(3)->sequence(
            ['numero_version' => 1, 'contenido' => 'v1'],
            ['numero_version' => 2, 'contenido' => 'v2'],
            ['numero_version' => 3, 'contenido' => 'v3'],
        )->create(['prompt_id' => $prompt->id]);

        // Ver historial
        $response = $this->actingAs($user)->get(route('prompts.historial', $prompt));

        $response->assertStatus(200);
        $response->assertViewHas('versiones');
        $response->assertViewHas('prompt', $prompt);

        // Validar que contiene las versiones
        $versiones = $response->viewData('versiones');
        $this->assertCount(3, $versiones);
    }

    /**
     * Test que usuario puede restaurar una versión anterior con contenido muy largo
     */
    public function test_user_can_restore_previous_version(): void
    {
        $user = User::factory()->create();

        // Contenido muy largo (próximo al límite de MySQL TEXT: 65,535 caracteres)
        $contenidoLargo1 = str_repeat('Contenido versión 1: ', 1000).str_repeat('A', 10000);
        $contenidoLargo2 = str_repeat('Contenido versión 2: ', 1000).str_repeat('B', 10000);
        $contenidoLargo3 = str_repeat('Contenido versión 3: ', 1000).str_repeat('C', 10000);

        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'contenido' => $contenidoLargo3,
            'version_actual' => 3,
        ]);

        // Crear 3 versiones con contenido largo
        $v1 = Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => $contenidoLargo1,
        ]);

        $v2 = Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 2,
            'contenido' => $contenidoLargo2,
        ]);

        $v3 = Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 3,
            'contenido' => $contenidoLargo3,
        ]);

        // Restaurar versión 1 (con contenido largo)
        $response = $this->actingAs($user)->post(
            route('prompts.restaurar', ['prompt' => $prompt, 'version' => $v1])
        );

        $response->assertRedirect(route('prompts.show', $prompt));

        // Refresh del prompt
        $prompt->refresh();

        // Validar que version_actual incrementó a 4
        $this->assertEquals(4, $prompt->version_actual);

        // Validar que el contenido es el de v1 (muy largo)
        $this->assertEquals($contenidoLargo1, $prompt->contenido);

        // Validar longitud del contenido restaurado (debe estar cercana a 30000 chars)
        $this->assertGreaterThan(20000, strlen($prompt->contenido));

        // Validar que existe versión 4 con el contenido restaurado
        $v4 = Version::where('prompt_id', $prompt->id)
            ->where('numero_version', 4)
            ->first();

        $this->assertNotNull($v4);
        $this->assertEquals($contenidoLargo1, $v4->contenido);
        $this->assertEquals(strlen($contenidoLargo1), strlen($v4->contenido));
        $this->assertStringContainsString('Restaurado desde versión 1', $v4->mensaje_cambio);
    }

    /**
     * Test que el numero_version se incrementa correctamente
     */
    public function test_numero_version_increments_correctly(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'contenido' => 'v1',
            'version_actual' => 1,
        ]);

        Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => 'v1',
        ]);

        // Editar 3 veces
        for ($i = 2; $i <= 4; $i++) {
            $this->actingAs($user)->put(route('prompts.update', $prompt), [
                'titulo' => $prompt->titulo,
                'descripcion' => $prompt->descripcion,
                'contenido' => "v{$i}",
                'visibilidad' => $prompt->visibilidad,
            ]);

            $prompt->refresh();
            $this->assertEquals($i, $prompt->version_actual);
        }

        // Validar que existen 4 versiones con numeros consecutivos
        $versiones = $prompt->versiones()->orderBy('numero_version')->get();
        $this->assertCount(4, $versiones);

        foreach ($versiones as $index => $version) {
            $this->assertEquals($index + 1, $version->numero_version);
        }
    }

    /**
     * Test que relación prompt->versiones funciona correctamente
     */
    public function test_prompt_versiones_relationship(): void
    {
        $prompt = Prompt::factory()->create(['version_actual' => 2]);

        Version::factory()->count(2)->sequence(
            ['numero_version' => 1],
            ['numero_version' => 2],
        )->create(['prompt_id' => $prompt->id]);

        // Cargar relación
        $prompt->load('versiones');

        $this->assertCount(2, $prompt->versiones);
        $this->assertEquals(1, $prompt->versiones[0]->numero_version);
        $this->assertEquals(2, $prompt->versiones[1]->numero_version);
    }

    /**
     * Test que solo propietario puede restaurar versiones
     */
    public function test_only_owner_can_restore_version(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        $version = Version::factory()->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
        ]);

        // Otro usuario intenta restaurar
        $response = $this->actingAs($otherUser)->post(
            route('prompts.restaurar', ['prompt' => $prompt, 'version' => $version])
        );

        $response->assertStatus(403);
    }

    /**
     * Test que no puede restaurar versión de otro prompt
     */
    public function test_cannot_restore_version_from_different_prompt(): void
    {
        $user = User::factory()->create();
        $prompt1 = Prompt::factory()->create(['user_id' => $user->id]);
        $prompt2 = Prompt::factory()->create(['user_id' => $user->id]);

        $versionDiferentePrompt = Version::factory()->create(['prompt_id' => $prompt2->id]);

        // Intentar restaurar versión de prompt2 en prompt1
        $response = $this->actingAs($user)->post(
            route('prompts.restaurar', ['prompt' => $prompt1, 'version' => $versionDiferentePrompt])
        );

        $response->assertStatus(403);
    }
}
