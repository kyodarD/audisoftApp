<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user')),
            ],
            'password' => $this->isMethod('post')
                ? 'required|string|min:6|confirmed'
                : 'nullable|string|min:6|confirmed', // Debería ser nullable en la actualización
            'password_confirmation' => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:5048',
            'estado' => 'required|in:0,1',
            'roles' => 'required|array',
            'roles.*' => ['exists:roles,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria en la creación.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password_confirmation.required' => 'Debes confirmar la contraseña.',
            'password_confirmation.min' => 'La confirmación debe tener al menos 6 caracteres.',
            'photo.image' => 'El archivo debe ser una imagen.',
            'photo.mimes' => 'La imagen debe ser de tipo jpg, png o jpeg.',
            'photo.max' => 'La imagen no debe superar los 5MB.',
            'estado.required' => 'El estado del usuario es obligatorio.',
            'estado.in' => 'El estado debe ser 0 (inactivo) o 1 (activo).',
            'roles.required' => 'Debes asignar al menos un rol al usuario.',
            'roles.*.exists' => 'Uno o más roles seleccionados no son válidos.',
        ];
    }
}
