<?php

namespace Tests\Feature\Sharing;

use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class CollaborationTest extends TestCase
{
    /**
     * Test que editor puede editar un prompt compartido
     */
    public function test_editor_puede_editar_prompt_compartido(): void
    {
        $owner = User::factory()->create();
        $editor = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'contenido' => 'Contenido original',
        ]);

        // Compartir como editor
        AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $editor->id,
            'nivel_acceso' => 'editor',
        ]);

        // Editor intenta editar
        $response = $this->actingAs($editor)->put(route('prompts.update', $prompt), [
            'titulo' => $prompt->titulo,
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Contenido modificado por editor',
            'visibilidad' => $prompt->visibilidad,
        ]);

        // Debe permitir (aunque la policy use compartirService que verifica acceso)
        $response->assertRedirect(route('prompts.show', $prompt));

        // Validar que se actualizó
        $prompt->refresh();
        $this->assertEquals('Contenido modificado por editor', $prompt->contenido);
    }

    /**
     * Test que comentador puede comentar pero NO editar
     */
    public function test_comentador_puede_comentar_no_editar(): void
    {
        $owner = User::factory()->create();
        $comentador = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'contenido' => 'Contenido original',
        ]);

        // Compartir como comentador
        AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $comentador->id,
            'nivel_acceso' => 'comentador',
        ]);

        // Comentador intenta editar - debe fallar (403)
        $response = $this->actingAs($comentador)->put(route('prompts.update', $prompt), [
            'titulo' => $prompt->titulo,
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Contenido modificado',
            'visibilidad' => $prompt->visibilidad,
        ]);

        $response->assertStatus(403);

        // Validar que NO se actualizó
        $prompt->refresh();
        $this->assertEquals('Contenido original', $prompt->contenido);
    }

    /**
     * Test que lector solo puede ver, no editar ni comentar
     */
    public function test_lector_solo_puede_ver(): void
    {
        $owner = User::factory()->create();
        $lector = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'contenido' => 'Contenido original',
        ]);

        // Compartir como lector
        AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $lector->id,
            'nivel_acceso' => 'lector',
        ]);

        // Lector puede ver
        $response = $this->actingAs($lector)->get(route('prompts.show', $prompt));
        $response->assertStatus(200);

        // Lector intenta editar - debe fallar
        $response = $this->actingAs($lector)->put(route('prompts.update', $prompt), [
            'titulo' => $prompt->titulo,
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Contenido modificado',
            'visibilidad' => $prompt->visibilidad,
        ]);

        $response->assertStatus(403);

        // Validar que NO se actualizó
        $prompt->refresh();
        $this->assertEquals('Contenido original', $prompt->contenido);
    }

    /**
     * Test que usuario sin acceso no puede ver ni editar
     */
    public function test_usuario_sin_acceso_no_puede_ver_ni_editar(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'privado',
        ]);

        // OtherUser NO tiene acceso compartido

        // No puede ver
        $response = $this->actingAs($otherUser)->get(route('prompts.show', $prompt));
        $response->assertStatus(403);

        // No puede editar
        $response = $this->actingAs($otherUser)->put(route('prompts.update', $prompt), [
            'titulo' => $prompt->titulo,
            'contenido' => 'Modificado',
            'visibilidad' => $prompt->visibilidad,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test que cambiar nivel de acceso actualiza permisos
     */
    public function test_cambiar_nivel_acceso_actualiza_permisos(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        // Compartir como lector
        $acceso = AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user->id,
            'nivel_acceso' => 'lector',
        ]);

        // User NO puede editar (lector)
        $response = $this->actingAs($user)->put(route('prompts.update', $prompt), [
            'titulo' => 'Nuevo título',
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Modificado',
            'visibilidad' => $prompt->visibilidad,
        ]);
        $response->assertStatus(403);

        // Cambiar nivel a editor
        $acceso->update(['nivel_acceso' => 'editor']);

        // Ahora user SÍ puede editar
        $response = $this->actingAs($user)->put(route('prompts.update', $prompt), [
            'titulo' => 'Nuevo título',
            'descripcion' => $prompt->descripcion,
            'contenido' => 'Contenido modificado',
            'visibilidad' => $prompt->visibilidad,
        ]);

        $response->assertRedirect(route('prompts.show', $prompt));

        // Validar actualización
        $prompt->refresh();
        $this->assertEquals('Nuevo título', $prompt->titulo);
    }
}
