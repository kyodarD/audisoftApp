<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'            => 'required|string|max:255',
            'cedula'            => 'required|string|max:20|unique:empleados,cedula',
            'telefono'          => 'required|string|max:15',
            'email'             => 'required|email|max:255|unique:empleados,email',
            'direccion'         => 'nullable|string|max:255',
            'cargo'             => 'required|string|max:100',
            'salario'           => 'required|numeric|min:0',
            'estado'            => 'required|in:activo,inactivo',

            // Nuevas relaciones
            'pais_id'           => 'required|exists:paises,id',
            'departamento_id'   => 'required|exists:departamentos,id',
            'ciudad_id'         => 'required|exists:ciudads,id',

            'user_id'           => 'required|exists:users,id',
            'registradopor'     => 'required|exists:users,id',
            'role_id'           => 'nullable|exists:roles,id',
            'photo'             => 'nullable|image|max:8048',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'            => 'nombre del empleado',
            'cedula'            => 'cédula',
            'telefono'          => 'teléfono',
            'email'             => 'correo electrónico',
            'direccion'         => 'dirección',
            'cargo'             => 'cargo',
            'salario'           => 'salario',
            'estado'            => 'estado',
            'pais_id'           => 'país',
            'departamento_id'   => 'departamento',
            'ciudad_id'         => 'ciudad',
            'user_id'           => 'usuario asociado',
            'registradopor'     => 'usuario que registró',
            'role_id'           => 'rol',
            'photo'             => 'foto del empleado',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'            => 'El nombre del empleado es obligatorio.',
            'cedula.required'            => 'La cédula es obligatoria.',
            'cedula.unique'              => 'Ya existe un empleado con esa cédula.',
            'telefono.required'          => 'El teléfono es obligatorio.',
            'email.required'             => 'El correo electrónico es obligatorio.',
            'email.email'                => 'El correo electrónico debe ser válido.',
            'email.unique'               => 'Ya existe un empleado con ese correo.',
            'cargo.required'             => 'El cargo es obligatorio.',
            'salario.required'           => 'El salario es obligatorio.',
            'salario.numeric'            => 'El salario debe ser un número.',
            'estado.required'            => 'El estado es obligatorio.',
            'estado.in'                  => 'El estado debe ser "activo" o "inactivo".',
            'pais_id.required'           => 'El país es obligatorio.',
            'pais_id.exists'             => 'El país seleccionado no es válido.',
            'departamento_id.required'   => 'El departamento es obligatorio.',
            'departamento_id.exists'     => 'El departamento seleccionado no es válido.',
            'ciudad_id.required'         => 'La ciudad es obligatoria.',
            'ciudad_id.exists'           => 'La ciudad seleccionada no es válida.',
            'user_id.required'           => 'Debe asociar este empleado a un usuario.',
            'user_id.exists'             => 'El usuario asociado no es válido.',
            'registradopor.required'     => 'Debe indicar qué usuario registró al empleado.',
            'registradopor.exists'       => 'El usuario que registró no es válido.',
            'role_id.exists'             => 'El rol seleccionado no existe.',
            'photo.image'                => 'La foto debe ser una imagen válida.',
            'photo.max'                  => 'La foto no debe superar los 8MB.',
        ];
    }
}
