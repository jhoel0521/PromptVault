<?php

namespace App\Http\Requests\Usuario;

use App\Http\Requests\Traits\ValidatePasswordPolicies;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    use ValidatePasswordPolicies;

    public function authorize(): bool
    {
        return $this->user()->esAdmin();
    }

    public function rules(): array
    {
        $usuarioId = $this->route('usuario');
        $passwordRules = $this->getPasswordRules();

        // Si no se proporciona password, hacerla opcional
        if (! $this->filled('password')) {
            $passwordRules = array_filter($passwordRules, function ($rule) {
                return $rule !== 'required' && $rule !== 'confirmed';
            });
            $passwordRules[] = 'nullable';
        }

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($usuarioId)],
            'password' => $passwordRules,
            'password_confirmation' => $this->filled('password') ? 'required|string' : 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'cuenta_activa' => 'required|boolean',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->getPasswordMessages(), [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.unique' => 'Este email ya está en uso',
            'role_id.required' => 'Debe seleccionar un rol',
        ]);
    }
}
