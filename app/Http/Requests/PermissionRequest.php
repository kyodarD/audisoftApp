<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Laravel verificará permisos en el controlador
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($this->route('permission')),
            ],
            'guard_name' => 'required|string|in:web', // Spatie usa 'web' por defecto
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'Este permiso ya existe.',
            'name.max' => 'El nombre del permiso no debe exceder los 255 caracteres.',
            'guard_name.required' => 'El guard_name es obligatorio.',
            'guard_name.in' => 'El guard_name debe ser "web".',
        ];
    }
}
