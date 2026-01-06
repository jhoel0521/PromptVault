<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Actualizar último acceso
            $user->update([
                'ultimo_acceso' => now()
            ]);

            // Redirigir según el rol del usuario
            return $this->redirectByRole($user);
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Redirigir según el rol del usuario
     */
    protected function redirectByRole($user)
    {
        // Si el usuario es administrador
        if ($user->esAdmin()) {
            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido Administrador!');
        }

        // Si el usuario es colaborador
        if ($user->role && $user->role->nombre === 'collaborator') {
            return redirect()->intended('/prompts')->with('success', '¡Bienvenido Colaborador!');
        }

        // Usuarios normales
        return redirect()->intended('/prompts')->with('success', '¡Bienvenido a PromptVault!');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }
}
