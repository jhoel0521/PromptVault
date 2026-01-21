<?php

namespace App\Http\Middleware;

use App\Models\AppSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener configuraciones
        $settings = AppSetting::getSettings();

        // Si no está en mantenimiento, continuar
        if (! $settings->maintenance_mode) {
            return $next($request);
        }
        // Permitir rutas públicas necesarias para autenticación
        if ($request->is('login') || $request->is('logout')) {
            return $next($request);
        }

        // Permitir acceso a admins autenticados
        if (Auth::check() && Auth::user()->role?->nombre === 'admin') {
            return $next($request);
        }

        // Mostrar página de mantenimiento
        return response()->view('maintenance', [], 503);
    }
}
