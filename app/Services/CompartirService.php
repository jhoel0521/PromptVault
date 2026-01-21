<?php

namespace App\Services;

use App\Contracts\Services\CompartirServiceInterface;
use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;

class CompartirService implements CompartirServiceInterface
{
    public function compartir(Prompt $prompt, User $usuario, string $nivelAcceso): AccesoCompartido
    {
        return AccesoCompartido::updateOrCreate(
            ['prompt_id' => $prompt->id, 'user_id' => $usuario->id],
            ['nivel_acceso' => $nivelAcceso]
        );
    }

    public function compartirPorEmail(Prompt $prompt, string $email, string $nivelAcceso): array
    {
        // Obtener usuario por email
        $usuario = User::where('email', $email)->first();

        if (! $usuario) {
            return [
                'success' => false,
                'message' => 'Usuario no encontrado',
                'acceso' => null,
            ];
        }

        // Validar que no sea el propietario
        if ($usuario->id === $prompt->user_id) {
            return [
                'success' => false,
                'message' => 'No puedes compartir contigo mismo',
                'acceso' => null,
            ];
        }

        // Compartir
        $acceso = $this->compartir($prompt, $usuario, $nivelAcceso);

        return [
            'success' => true,
            'message' => "Prompt compartido con {$usuario->name}",
            'acceso' => $acceso,
        ];
    }

    public function quitarAcceso(Prompt $prompt, User $usuario): bool
    {
        return AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $usuario->id)
            ->delete() > 0;
    }

    public function verificarAcceso(Prompt $prompt, ?User $usuario): ?string
    {
        // Sin usuario, verificar si es público
        if ($usuario === null) {
            return $prompt->visibilidad === 'publico' ? 'lector' : null;
        }

        // Propietario tiene acceso total
        if ($prompt->user_id === $usuario->id) {
            return 'propietario';
        }

        // Verificar acceso compartido
        $acceso = AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $usuario->id)
            ->first();

        if ($acceso) {
            return $acceso->nivel_acceso;
        }

        // Si es público, puede leer
        if ($prompt->visibilidad === 'publico') {
            return 'lector';
        }

        return null;
    }

    public function puedeEditar(Prompt $prompt, ?User $usuario): bool
    {
        $acceso = $this->verificarAcceso($prompt, $usuario);

        return in_array($acceso, ['propietario', 'editor']);
    }

    public function puedeComentar(Prompt $prompt, ?User $usuario): bool
    {
        $acceso = $this->verificarAcceso($prompt, $usuario);

        return in_array($acceso, ['propietario', 'editor', 'comentador']);
    }
}
