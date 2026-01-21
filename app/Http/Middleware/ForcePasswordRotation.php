<?php

namespace App\Http\Middleware;

use App\Models\AppSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordRotation
{
    /**
     * Middleware que valida si el usuario debe cambiar contraseña obligatoriamente
     * Si password_force_rotation está activo, redirige a cambiar contraseña
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $settings = AppSetting::getSettings();

            // Si forzar renovación está activo y el usuario no está en la ruta de cambio
            if ($settings->password_force_rotation && ! $request->routeIs('perfil.cambiar-password', 'perfil.actualizar-password')) {
                return redirect()->route('perfil.cambiar-password')
                    ->with('warning', 'Debe cambiar su contraseña obligatoriamente.');
            }
        }

        return $next($request);
    }
}
