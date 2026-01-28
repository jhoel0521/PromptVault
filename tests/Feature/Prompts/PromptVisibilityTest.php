<?php

namespace Tests\Feature\Prompts;

use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class PromptVisibilityTest extends TestCase
{
    /**
     * Test que prompts públicos son visibles para todos autenticados
     */
    public function test_public_prompts_visible_to_all(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $guestUser = null;

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        // El dueño ve el prompt (lógica model)
        $this->assertTrue($prompt->esVisiblePara($owner));

        // Otro usuario ve el prompt (lógica model)
        $this->assertTrue($prompt->esVisiblePara($otherUser));

        // Usuario no autenticado ve el prompt (lógica model)
        $this->assertTrue($prompt->esVisiblePara($guestUser));

        // Via HTTP: Cualquier usuario autenticado puede ver prompt público
        $response = $this->actingAs($otherUser)->get(route('prompts.show', $prompt));
        $response->assertStatus(200);
    }

    /**
     * Test que prompts privados están ocultos de otros usuarios
     */
    public function test_private_prompts_hidden_from_others(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'privado',
        ]);

        // El dueño ve el prompt (lógica model)
        $this->assertTrue($prompt->esVisiblePara($owner));

        // Otro usuario NO ve el prompt (lógica model)
        $this->assertFalse($prompt->esVisiblePara($otherUser));

        // Usuario no autenticado NO ve el prompt (lógica model)
        $this->assertFalse($prompt->esVisiblePara(null));

        // Via HTTP: Otro usuario recibe 403 por policy
        $this->actingAs($otherUser)
            ->get(route('prompts.show', $prompt))
            ->assertStatus(403);
    }

    /**
     * Test que prompts compartidos son visibles para usuarios con acceso
     */
    public function test_shared_prompts_visible_to_shared_users(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();
        $otherUser = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'privado',
        ]);

        // Compartir con sharedUser
        AccesoCompartido::factory()->create([
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
            'nivel_acceso' => 'lector',
        ]);

        // El dueño ve el prompt
        $this->assertTrue($prompt->esVisiblePara($owner));

        // Usuario con acceso compartido ve el prompt
        $this->assertTrue($prompt->esVisiblePara($sharedUser));

        // Usuario sin acceso NO ve el prompt
        $this->assertFalse($prompt->esVisiblePara($otherUser));

        // Via HTTP: Usuario compartido puede ver
        $this->actingAs($sharedUser)
            ->get(route('prompts.show', $prompt))
            ->assertStatus(200);

        // Via HTTP: Usuario sin acceso recibe 403
        $this->actingAs($otherUser)
            ->get(route('prompts.show', $prompt))
            ->assertStatus(403);
    }

    /**
     * Test que admin NO puede ver prompts privados de otros (respeta privacidad)
     */
    public function test_admin_cannot_see_private_prompts_via_policy(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create();
        // El admin es quien tiene role_id = 1 (admin role)
        $admin->update(['role_id' => 1]);

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'privado',
        ]);

        // Modelo: Admin NO puede ver (esVisiblePara respeta privacidad)
        $this->assertFalse($prompt->esVisiblePara($admin));

        // Policy HTTP: Admin NO puede ver
        $this->actingAs($admin)
            ->get(route('prompts.show', $prompt))
            ->assertStatus(403);
    }

    /**
     * Test que prompts de enlace son tratados como privados
     */
    public function test_link_prompts_treated_as_private(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'enlace',
        ]);

        // El dueño ve el prompt
        $this->assertTrue($prompt->esVisiblePara($owner));

        // Usuario autenticado NO ve el prompt sin acceso compartido
        $this->assertFalse($prompt->esVisiblePara($otherUser));

        // Usuario no autenticado NO ve el prompt
        $this->assertFalse($prompt->esVisiblePara(null));

        // Via HTTP: Usuario sin acceso recibe 403
        $this->actingAs($otherUser)
            ->get(route('prompts.show', $prompt))
            ->assertStatus(403);
    }

    /**
     * Test que el nivel de acceso de propietario se retorna correctamente
     */
    public function test_owner_has_propietario_access_level(): void
    {
        $owner = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        $nivel = $prompt->nivelAccesoPara($owner);
        $this->assertEquals('propietario', $nivel);
    }

    /**
     * Test que el nivel de acceso de usuario compartido se retorna correctamente
     */
    public function test_shared_user_has_correct_access_level(): void
    {
        $owner = User::factory()->create();
        $sharedUser = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        AccesoCompartido::factory()->create([
            'prompt_id' => $prompt->id,
            'user_id' => $sharedUser->id,
            'nivel_acceso' => 'comentador',
        ]);

        $nivel = $prompt->nivelAccesoPara($sharedUser);
        $this->assertEquals('comentador', $nivel);
    }

    /**
     * Test que usuario sin acceso no tiene nivel de acceso
     */
    public function test_user_without_access_has_no_level(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $owner->id]);

        $nivel = $prompt->nivelAccesoPara($otherUser);
        $this->assertNull($nivel);
    }
}
