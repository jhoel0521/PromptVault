<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    /**
     * Test que admin puede listar usuarios
     */
    public function test_admin_puede_listar_usuarios(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // Admin role

        User::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get(route('admin.usuarios.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.usuarios.index');
    }

    /**
     * Test que admin puede crear usuario
     */
    public function test_admin_puede_crear_usuario(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // Admin role

        $response = $this->actingAs($admin)->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'Password123!@#',  // Contraseña fuerte
            'password_confirmation' => 'Password123!@#',
            'role_id' => 2,
            'cuenta_activa' => true,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
        ]);
    }

    /**
     * Test que admin puede desactivar usuario
     */
    public function test_admin_puede_desactivar_usuario(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // Admin role

        $user = User::factory()->create([
            'cuenta_activa' => true,
        ]);

        $response = $this->actingAs($admin)->put(
            route('admin.usuarios.update', ['usuario' => $user]),
            [
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'cuenta_activa' => false,
            ]
        );

        $response->assertRedirect();

        $user->refresh();
        $this->assertFalse($user->cuenta_activa);
    }

    /**
     * Test que admin puede cambiar rol de usuario
     */
    public function test_admin_puede_cambiar_rol_usuario(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // Admin role

        $user = User::factory()->create([
            'role_id' => 2, // Usuario normal
            'cuenta_activa' => true,
        ]);

        $response = $this->actingAs($admin)->put(
            route('admin.usuarios.update', ['usuario' => $user->id]),
            [
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => 1, // Cambiar a admin
                'cuenta_activa' => true,
            ]
        );

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $user->refresh();
        $this->assertEquals(1, $user->role_id);
    }

    /**
     * Test que non-admin no puede acceder a gestión de usuarios
     */
    public function test_no_admin_no_puede_acceder_gestion_usuarios(): void
    {
        $user = User::factory()->create();
        $user->update(['role_id' => 2]); // Usuario normal

        // Intentar acceder a la lista
        $response = $this->actingAs($user)->get(route('admin.usuarios.index'));
        $response->assertStatus(403);

        // Intentar crear usuario
        $response = $this->actingAs($user)->post(route('admin.usuarios.store'), [
            'name' => 'Intento',
            'email' => 'intento@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => 2,
        ]);
        $response->assertStatus(403);
    }
}
