<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Ajustar si se requiere control de acceso
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:empleados,cedula,' . $this->route('empleado'),
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:empleados,email,' . $this->route('empleado'),
            'direccion' => 'nullable|string|max:255',
            'cargo' => 'required|string|max:100',
            'salario' => 'required|numeric|min:0|max:9999999999.99',
            'estado' => 'required|in:activo,inactivo',
            'registradopor' => 'nullable|integer|exists:users,id',
            'user_id' => 'required|integer|exists:users,id', // Verifica que el usuario exista
            'role_id' => 'required|integer|exists:roles,id', // Asegura que se pase un solo rol válido
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Esta cédula ya está registrada.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'cargo.required' => 'El cargo es obligatorio.',
            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.max' => 'El salario no puede superar los 9,999,999,999.99.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'user_id.required' => 'El usuario asociado es obligatorio.',
            'user_id.exists' => 'El usuario no existe en la base de datos.',
            'role_id.required' => 'El rol es obligatorio.',
            'role_id.exists' => 'El rol seleccionado no es válido.',
        ];
    }
}
