<?php

use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PromptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (sin autenticación)
|--------------------------------------------------------------------------
*/

// Página principal pública - muestra prompts públicos
Route::get('/', [HomeController::class, 'index'])->name('home');

// Búsqueda pública
Route::get('buscador/search', [BuscadorController::class, 'search'])->name('buscador.search');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('prompts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/seguridad', [PerfilController::class, 'cambiarPassword'])->name('perfil.security');
    Route::post('/perfil/password', [PerfilController::class, 'actualizarPassword'])->name('perfil.password');
    Route::post('/perfil/avatar', [PerfilController::class, 'subirAvatar'])->name('perfil.avatar');

    // Prompts (CRUD)
    Route::resource('prompts', PromptController::class);

    // Prompts adicionales
    Route::post('/prompts/{prompt}/compartir', [PromptController::class, 'compartir'])->name('prompts.compartir');
    Route::delete('/prompts/{prompt}/acceso/{user}', [PromptController::class, 'quitarAcceso'])->name('prompts.quitarAcceso');
    Route::get('/prompts/{prompt}/historial', [PromptController::class, 'historial'])->name('prompts.historial');
    Route::post('/prompts/{prompt}/versiones/{version}/restaurar', [PromptController::class, 'restaurarVersion'])->name('prompts.restaurar');
    Route::get('/compartidos-conmigo', [PromptController::class, 'compartidosConmigo'])->name('prompts.compartidosConmigo');

    // Calendario
    Route::resource('calendario', CalendarioController::class);

    // Buscador
    Route::get('buscador', [BuscadorController::class, 'search'])->name('buscador.index');

    // Configuraciones
    Route::prefix('configuraciones')->name('configuraciones.')->group(function () {
        Route::get('/', [ConfiguracionesController::class, 'index'])->name('index');
        Route::get('/general', [ConfiguracionesController::class, 'general'])->name('general');
        Route::get('/seguridad', [ConfiguracionesController::class, 'seguridad'])->name('seguridad');
        Route::get('/notificaciones', [ConfiguracionesController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/apariencia', [ConfiguracionesController::class, 'apariencia'])->name('apariencia');
        Route::get('/sistema', [ConfiguracionesController::class, 'sistema'])->name('sistema');
        Route::get('/respaldos', [ConfiguracionesController::class, 'respaldos'])->name('respaldos');
        Route::post('/update', [ConfiguracionesController::class, 'update'])->name('update');
    });

    // Administración (solo admin)
    Route::middleware(['can:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    });
});

Route::middleware('auth')->prefix('chatbot')->group(function () {
    Route::post('/ask', [App\Http\Controllers\ChatbotController::class, 'ask'])->name('chatbot.ask');
    Route::get('/providers', [App\Http\Controllers\ChatbotController::class, 'providers'])->name('chatbot.providers');
});
require __DIR__.'/auth.php';
