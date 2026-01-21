<?php

namespace App\Http\Requests\Usuario;

use App\Http\Requests\Traits\ValidatePasswordPolicies;
use App\Models\AppSetting;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    use ValidatePasswordPolicies;

    public function authorize(): bool
    {
        return $this->user()->esAdmin();
    }

    public function rules(): array
    {
        $settings = AppSetting::getSettings();
        $passwordRules = $this->getPasswordRules();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => $passwordRules,
            'password_confirmation' => 'required|string',
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
            'email.unique' => 'Este email ya está registrado',
            'role_id.required' => 'Debe seleccionar un rol',
            'role_id.exists' => 'El rol seleccionado no existe',
        ]);
    }
}
