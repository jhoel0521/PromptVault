<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Prompts
    Route::resource('prompts', PromptController::class);
    
    // Rutas adicionales de Prompts
    Route::post('/prompts/{prompt}/favorito', [PromptController::class, 'toggleFavorito'])->name('prompts.favorito');
    Route::post('/prompts/{prompt}/uso', [PromptController::class, 'incrementarUso'])->name('prompts.uso');
    Route::post('/prompts/{prompt}/compartir', [PromptController::class, 'compartir'])->name('prompts.compartir');
    Route::get('/prompts/{prompt}/historial', [PromptController::class, 'historial'])->name('prompts.historial');
    Route::post('/prompts/{prompt}/versiones/{version}/restaurar', [PromptController::class, 'restaurarVersion'])->name('prompts.restaurar');
});

require __DIR__.'/auth.php';
