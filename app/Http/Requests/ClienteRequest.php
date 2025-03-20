<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permite el acceso al request
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) { // Reglas para crear un cliente
            return [
                'nombre' => 'required|string|max:255|unique:clientes,nombre|regex:/^[\pL\s\-]+$/u',
                'cedula' => 'required|unique:clientes,cedula|max:20', // Agregar cedula única y requerida
                'email' => 'nullable|email|max:255|unique:clientes,email', // Añadí unique para asegurar que el correo sea único
                'telefono' => 'nullable|string|max:15|regex:/^[0-9\-]+$/',
                'direccion' => 'nullable|string|max:255',
                'estado' => 'required|in:activo,inactivo',
            ];
        } elseif ($this->isMethod('put')) { // Reglas para actualizar un cliente
            return [
                'nombre' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u|unique:clientes,nombre,' . $this->route('cliente')->id, // Excluye el cliente actual de la validación unique
                'cedula' => 'required|unique:clientes,cedula,' . $this->route('cliente')->id . '|max:20', // Asegurarse de que la cedula sea única, excepto para el cliente actual
                'email' => 'nullable|email|max:255|unique:clientes,email,' . $this->route('cliente')->id, // Excluye el cliente actual de la validación unique para email
                'telefono' => 'nullable|string|max:15|regex:/^[0-9\-]+$/',
                'direccion' => 'nullable|string|max:255',
                'estado' => 'required|in:activo,inactivo',
            ];
        }

        // Retorno predeterminado para otros métodos HTTP
        return [];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'nombre.unique' => 'El nombre del cliente ya está registrado.',
            'nombre.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'La cédula ya está registrada.',
            'cedula.max' => 'La cédula no puede superar los 20 caracteres.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'telefono.regex' => 'El teléfono solo puede contener números y guiones.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
        ];
    }
}
