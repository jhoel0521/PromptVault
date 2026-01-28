<?php

namespace Tests\Feature\Prompts;

use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class PromptCrudTest extends TestCase
{
    /**
     * Test que un usuario puede crear un prompt
     */
    public function test_user_can_create_prompt(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('prompts.store'), [
            'titulo' => 'Test Prompt',
            'descripcion' => 'Test description',
            'contenido' => 'Test content',
            'visibilidad' => 'privado',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prompts', [
            'titulo' => 'Test Prompt',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test que un usuario puede ver sus propios prompts
     */
    public function test_user_can_view_own_prompts(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('prompts.show', $prompt));

        $response->assertStatus(200);
    }

    /**
     * Test que un usuario puede actualizar su propio prompt
     */
    public function test_user_can_update_own_prompt(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('prompts.update', $prompt), [
            'titulo' => 'Updated Title',
            'descripcion' => 'Updated description',
            'contenido' => 'Updated content',
            'visibilidad' => 'publico',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prompts', [
            'id' => $prompt->id,
            'titulo' => 'Updated Title',
        ]);
    }

    /**
     * Test que un usuario puede eliminar su propio prompt
     */
    public function test_user_can_delete_own_prompt(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('prompts.destroy', $prompt));

        $response->assertRedirect();
        $this->assertModelMissing($prompt);
    }

    /**
     * Test que un usuario NO puede eliminar prompts ajenos
     */
    public function test_user_cannot_delete_others_prompt(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->delete(route('prompts.destroy', $prompt));

        $response->assertForbidden();
        $this->assertModelExists($prompt);
    }

    /**
     * Test que un admin puede eliminar cualquier prompt
     */
    public function test_admin_can_delete_any_prompt(): void
    {
        $admin = User::factory()->create(['role_id' => 1]); // admin role
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->delete(route('prompts.destroy', $prompt));

        $response->assertRedirect();
        $this->assertModelMissing($prompt);
    }

    /**
     * Test que un usuario no puede actualizar prompts ajenos
     */
    public function test_user_cannot_update_others_prompt(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->put(route('prompts.update', $prompt), [
            'titulo' => 'Hacked',
            'descripcion' => 'Hacked',
            'contenido' => 'Hacked',
            'visibilidad' => 'privado',
        ]);

        $response->assertForbidden();
    }

    /**
     * Test que usuario no autenticado no puede crear prompts
     */
    public function test_unauthenticated_user_cannot_create_prompt(): void
    {
        $response = $this->post(route('prompts.store'), [
            'titulo' => 'Test',
            'descripcion' => 'Test',
            'contenido' => 'Test',
            'visibilidad' => 'privado',
        ]);

        $response->assertRedirect(route('login'));
    }
}
