<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Laravel verificará si el usuario tiene permisos con middleware
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'regex:/^[\pL\s\-]+$/u', // Solo letras, espacios y guiones
                Rule::unique('roles', 'name')->ignore($this->route('role')),
            ],
            'guard_name' => 'required|in:web', // Spatie usa 'web' por defecto
            'description' => 'nullable|string|max:500', // Permitir descripción opcional
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'El nombre del rol ya existe.',
            'name.regex' => 'El nombre del rol solo puede contener letras, espacios y guiones.',
            'guard_name.required' => 'El campo guard_name es obligatorio.',
            'guard_name.in' => 'El valor de guard_name debe ser "web".',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
        ];
    }
}
