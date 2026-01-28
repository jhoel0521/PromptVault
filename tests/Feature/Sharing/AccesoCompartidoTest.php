<?php

namespace Tests\Feature\Sharing;

use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class AccesoCompartidoTest extends TestCase
{
    /**
     * Test que propietario puede compartir un prompt
     */
    public function test_owner_can_share_prompt(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'privado',
        ]);

        // Compartir prompt
        $response = $this->actingAs($owner)->post(route('prompts.compartir', $prompt), [
            'email' => $sharedUser->email,
            'nivel_acceso' => 'lector',
        ]);

        $response->assertRedirect();

        // Validar que se creó AccesoCompartido
        $this->assertDatabaseHas('accesos_compartidos', [
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
            'nivel_acceso' => 'lector',
        ]);
    }

    /**
     * Test que se puede compartir con nivel 'lector'
     */
    public function test_share_with_lector_level(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($owner)->post(route('prompts.compartir', $prompt), [
            'email' => $sharedUser->email,
            'nivel_acceso' => 'lector',
        ]);

        // Validar acceso creado
        $acceso = AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $sharedUser->id)
            ->first();

        $this->assertNotNull($acceso);
        $this->assertEquals('lector', $acceso->nivel_acceso);

        // Lector NO puede editar
        $this->assertFalse($prompt->nivelAccesoPara($sharedUser) === 'editor');

        // Lector puede ver (está en acceso compartido)
        $this->assertTrue($prompt->esVisiblePara($sharedUser));
    }

    /**
     * Test que se puede compartir con nivel 'comentador'
     */
    public function test_share_with_comentador_level(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($owner)->post(route('prompts.compartir', $prompt), [
            'email' => $sharedUser->email,
            'nivel_acceso' => 'comentador',
        ]);

        // Validar acceso creado
        $acceso = AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $sharedUser->id)
            ->first();

        $this->assertNotNull($acceso);
        $this->assertEquals('comentador', $acceso->nivel_acceso);

        // Comentador puede ver
        $this->assertTrue($prompt->esVisiblePara($sharedUser));
    }

    /**
     * Test que se puede compartir con nivel 'editor'
     */
    public function test_share_with_editor_level(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($owner)->post(route('prompts.compartir', $prompt), [
            'email' => $sharedUser->email,
            'nivel_acceso' => 'editor',
        ]);

        // Validar acceso creado
        $acceso = AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $sharedUser->id)
            ->first();

        $this->assertNotNull($acceso);
        $this->assertEquals('editor', $acceso->nivel_acceso);

        // Editor puede ver
        $this->assertTrue($prompt->esVisiblePara($sharedUser));
    }

    /**
     * Test que propietario puede revocar acceso
     */
    public function test_owner_can_revoke_access(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        // Compartir primero
        AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
            'nivel_acceso' => 'lector',
        ]);

        // Validar que existe
        $this->assertDatabaseHas('accesos_compartidos', [
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
        ]);

        // Revocar acceso
        $response = $this->actingAs($owner)->delete(
            route('prompts.quitarAcceso', ['prompt' => $prompt, 'user' => $sharedUser])
        );

        $response->assertRedirect();

        // Validar que NO existe más
        $this->assertDatabaseMissing('accesos_compartidos', [
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
        ]);

        // Refresh del modelo para validar
        $prompt->refresh();

        // Usuario ya no puede ver el prompt
        $this->assertFalse($prompt->esVisiblePara($sharedUser));
    }

    /**
     * Test que no se puede compartir con uno mismo
     */
    public function test_cannot_share_with_self(): void
    {
        $owner = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        // Intentar compartir consigo mismo
        $response = $this->actingAs($owner)->post(route('prompts.compartir', $prompt), [
            'email' => $owner->email,
            'nivel_acceso' => 'lector',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }

    /**
     * Test que solo propietario puede revocar acceso
     */
    public function test_only_owner_can_revoke_access(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();
        $otherUser = User::factory()->create();

        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        AccesoCompartido::create([
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
            'nivel_acceso' => 'lector',
        ]);

        // Otro usuario intenta revocar
        $response = $this->actingAs($otherUser)->delete(
            route('prompts.quitarAcceso', ['prompt' => $prompt, 'user' => $sharedUser])
        );

        $response->assertStatus(403);
    }
}
