<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Primero crear roles y permisos
        $this->call([
            RoleSeeder::class,
            PermisoSeeder::class,
        ]);

        // 2. Crear etiquetas (unificación de categorías + etiquetas)
        $this->call([
            EtiquetaSeeder::class,
        ]);

        // 3. Crear usuarios base
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@promptvault.com',
            'role_id' => 1, // Admin
        ]);

        User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'user@promptvault.com',
            'role_id' => 2, // User
        ]);

        // 4. Crear usuarios adicionales
        $this->call([
            UserSeeder::class,
        ]);

        // 5. Crear prompts con etiquetas
        $this->call([
            PromptSeeder::class,
        ]);

        // 6. Crear versionado de prompts
        $this->call([
            VersionSeeder::class,
        ]);

        // 7. Crear eventos del calendario
        $this->call([
            EventoSeeder::class,
        ]);

        // 8. Crear accesos compartidos (Req 3: compartir tipo Google Docs)
        $this->call([
            AccesoCompartidoSeeder::class,
        ]);

        // 9. Crear comentarios (Req 4)
        $this->call([
            ComentarioSeeder::class,
        ]);

        // 10. Crear calificaciones (Req 5: estrellas)
        $this->call([
            CalificacionSeeder::class,
        ]);
    }
}
