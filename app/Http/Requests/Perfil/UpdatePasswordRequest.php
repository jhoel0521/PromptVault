<?php

namespace App\Http\Requests\Perfil;

use App\Http\Requests\Traits\ValidatePasswordPolicies;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    use ValidatePasswordPolicies;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $passwordRules = $this->getPasswordRules();

        return [
            'current_password' => 'required',
            'new_password' => $passwordRules,
            'new_password_confirmation' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return array_merge($this->getPasswordMessages(), [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'new_password.required' => 'La nueva contraseña es obligatoria',
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (! Hash::check($this->current_password, $this->user()->password)) {
                $validator->errors()->add('current_password', 'La contraseña actual no es correcta');
            }
        });
    }
}
