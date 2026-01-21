<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@promptvault.com')->first();

        if (! $admin) {
            $this->command->warn('No se encontró usuario admin, saltando EventoSeeder');

            return;
        }

        $eventos = [
            // Eventos pasados completados
            [
                'user_id' => $admin->id,
                'titulo' => 'Reunión con equipo de desarrollo',
                'descripcion' => 'Revisión de sprints y planificación Q1',
                'fecha_inicio' => Carbon::now()->subDays(15)->setHour(10)->setMinute(0),
                'fecha_fin' => Carbon::now()->subDays(15)->setHour(12)->setMinute(0),
                'tipo' => 'reunion',
                'ubicacion' => 'Sala de Conferencias A',
                'todo_el_dia' => false,
                'completado' => true,
                'color' => '#3b82f6',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Workshop: Mejores prácticas Laravel',
                'descripcion' => 'Taller sobre patrones de diseño y arquitectura limpia',
                'fecha_inicio' => Carbon::now()->subDays(10)->setHour(14)->setMinute(0),
                'fecha_fin' => Carbon::now()->subDays(10)->setHour(18)->setMinute(0),
                'tipo' => 'trabajo',
                'ubicacion' => 'Zoom',
                'todo_el_dia' => false,
                'completado' => true,
                'color' => '#10b981',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Entrega MVP Cliente XYZ',
                'descripcion' => 'Presentación de prototipo funcional',
                'fecha_inicio' => Carbon::now()->subDays(7)->setHour(11)->setMinute(0),
                'fecha_fin' => Carbon::now()->subDays(7)->setHour(13)->setMinute(0),
                'tipo' => 'reunion',
                'ubicacion' => 'Google Meet',
                'todo_el_dia' => false,
                'completado' => true,
                'color' => '#f59e0b',
            ],

            // Eventos próximos pendientes
            [
                'user_id' => $admin->id,
                'titulo' => 'Code Review: Módulo Auth',
                'descripcion' => 'Revisión de código del sistema de autenticación',
                'fecha_inicio' => Carbon::now()->addDays(2)->setHour(15)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(2)->setHour(16)->setMinute(30),
                'tipo' => 'trabajo',
                'ubicacion' => null,
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#10b981',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Deploy a Producción',
                'descripcion' => 'Despliegue de versión 2.0 - verificar rollback plan',
                'fecha_inicio' => Carbon::now()->addDays(5)->setHour(22)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(5)->setHour(23)->setMinute(30),
                'tipo' => 'trabajo',
                'ubicacion' => 'Remoto',
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#ef4444',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Sprint Planning',
                'descripcion' => 'Planificación de tareas para próximo sprint',
                'fecha_inicio' => Carbon::now()->addDays(7)->setHour(9)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(7)->setHour(11)->setMinute(0),
                'tipo' => 'reunion',
                'ubicacion' => 'Oficina Central',
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#3b82f6',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Conferencia PHP Latinoamérica',
                'descripcion' => 'Evento online sobre últimas tendencias PHP 8.4 y Laravel 12',
                'fecha_inicio' => Carbon::now()->addDays(14)->setHour(9)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(14)->setHour(18)->setMinute(0),
                'tipo' => 'personal',
                'ubicacion' => 'Online',
                'todo_el_dia' => true,
                'completado' => false,
                'color' => '#8b5cf6',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Capacitación: Chart.js y D3.js',
                'descripcion' => 'Aprender visualización de datos para dashboard',
                'fecha_inicio' => Carbon::now()->addDays(21)->setHour(16)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(21)->setHour(18)->setMinute(0),
                'tipo' => 'personal',
                'ubicacion' => 'Udemy',
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#8b5cf6',
            ],

            // Eventos del mes actual
            [
                'user_id' => $admin->id,
                'titulo' => 'Daily Standup',
                'descripcion' => 'Sincronización diaria del equipo',
                'fecha_inicio' => Carbon::now()->addDays(1)->setHour(9)->setMinute(30),
                'fecha_fin' => Carbon::now()->addDays(1)->setHour(9)->setMinute(45),
                'tipo' => 'reunion',
                'ubicacion' => 'Slack Call',
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#3b82f6',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Testing QA Módulo Reportes',
                'descripcion' => 'Pruebas de integración y end-to-end',
                'fecha_inicio' => Carbon::now()->addDays(3)->setHour(14)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(3)->setHour(17)->setMinute(0),
                'tipo' => 'trabajo',
                'ubicacion' => null,
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#10b981',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Documentación API REST',
                'descripcion' => 'Actualizar Swagger con nuevos endpoints',
                'fecha_inicio' => Carbon::now()->addDays(8)->setHour(10)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(8)->setHour(12)->setMinute(0),
                'tipo' => 'trabajo',
                'ubicacion' => null,
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#10b981',
            ],
            [
                'user_id' => $admin->id,
                'titulo' => 'Backup Database Mensual',
                'descripcion' => 'Verificar integridad de respaldos automáticos',
                'fecha_inicio' => Carbon::now()->addDays(28)->setHour(23)->setMinute(0),
                'fecha_fin' => Carbon::now()->addDays(28)->setHour(23)->setMinute(30),
                'tipo' => 'trabajo',
                'ubicacion' => 'Servidor Cloud',
                'todo_el_dia' => false,
                'completado' => false,
                'color' => '#ef4444',
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }

        $this->command->info('✅ Creados '.count($eventos).' eventos de ejemplo');
    }
}
