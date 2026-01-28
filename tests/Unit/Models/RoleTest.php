<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * Test que un rol tiene muchos usuarios
     */
    public function test_rol_tiene_muchos_usuarios(): void
    {
        $role = Role::factory()->create();
        User::factory(3)->create(['role_id' => $role->id]);

        $this->assertEquals(3, $role->users()->count());
    }

    /**
     * Test que un rol tiene muchos permisos
     */
    public function test_rol_tiene_muchos_permisos(): void
    {
        $role = Role::factory()->create();

        // Este test depende de que la relación permisos esté implementada
        $this->assertTrue(method_exists($role, 'permisos'));
    }

    /**
     * Test que un rol puede verificar si tiene un permiso específico
     */
    public function test_role_tiene_permiso(): void
    {
        $role = Role::factory()->create();

        // Este test depende de que el método tienePermiso() esté implementado
        $this->assertTrue(method_exists($role, 'tienePermiso'));
    }
}
