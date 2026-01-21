<?php

use Illuminate\Support\Facades\Route;

Route::middleware('maintenance')->group(function () {
    // Rutas principales y de autenticación pasan por mantenimiento
    require __DIR__.'/web.php';
    require __DIR__.'/auth.php';
});
