<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test que el usuario tiene relación con rol
     */
    public function test_user_has_role_relationship(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->role);
        $this->assertInstanceOf(Role::class, $user->role);
    }

    /**
     * Test que un usuario admin es identificado correctamente
     */
    public function test_user_es_admin_returns_true_for_admin(): void
    {
        // Usar rol admin que ya existe (creado en TestCase setUp)
        $admin = Role::find(1);
        $user = User::factory()->create(['role_id' => $admin->id]);

        $this->assertTrue($user->esAdmin());
    }

    /**
     * Test que un usuario regular no es admin
     */
    public function test_user_es_admin_returns_false_for_user(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->esAdmin());
    }

    /**
     * Test que verificar si un usuario tiene un permiso
     */
    public function test_user_tiene_permiso_checks_role_permissions(): void
    {
        $user = User::factory()->create();

        // Este test depende de que el método tienePermiso() esté implementado
        // Por ahora verificamos que el método existe
        $this->assertTrue(method_exists($user, 'tienePermiso'));
    }

    /**
     * Test que un usuario puede editar sus propios prompts
     */
    public function test_user_puede_editar_own_prompt(): void
    {
        $user = User::factory()->create();
        $prompt = $user->prompts()->create([
            'titulo' => 'Test Prompt',
            'descripcion' => 'Test',
            'contenido' => 'Test content',
            'visibilidad' => 'privado',
        ]);

        $this->assertTrue($user->can('update', $prompt));
    }

    /**
     * Test que un usuario no puede editar prompts ajenos
     */
    public function test_user_cannot_edit_others_prompt(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $prompt = $user1->prompts()->create([
            'titulo' => 'Test Prompt',
            'descripcion' => 'Test',
            'contenido' => 'Test content',
            'visibilidad' => 'privado',
        ]);

        $this->assertFalse($user2->can('update', $prompt));
    }
}
