<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    /**
     * Determine si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        $proveedorId = $this->proveedor ? $this->proveedor->id : null;

        return [
            'nombre' => ['required', 'string', 'max:255'],
            'cedula' => ['required', 'string', 'max:20', 'unique:proveedores,cedula,' . $proveedorId],
            'email' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:15'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'estado' => ['required', 'in:activo,inactivo'],
            'registradopor' => ['required', 'exists:users,id'],
        ];
    }

    /**
     * Obtener los mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
            'cedula.required' => 'La cédula del proveedor es obligatoria.',
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'cedula.max' => 'La cédula no puede exceder los 20 caracteres.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            'telefono.max' => 'El teléfono no puede exceder los 15 caracteres.',
            'direccion.max' => 'La dirección no puede exceder los 255 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'registradopor.required' => 'El usuario que registra es obligatorio.',
            'registradopor.exists' => 'El usuario registrador no existe en el sistema.',
        ];
    }

    /**
     * Preparar los datos para la validación.
     */
    protected function prepareForValidation(): void
    {
        // Asegurarse de que el estado sea minúsculas
        if ($this->has('estado')) {
            $this->merge([
                'estado' => strtolower($this->estado)
            ]);
        }
    }

    /**
     * Obtener los atributos personalizados para los errores del validador.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre del proveedor',
            'cedula' => 'cédula del proveedor',
            'email' => 'correo electrónico',
            'telefono' => 'número de teléfono',
            'direccion' => 'dirección',
            'estado' => 'estado',
            'registradopor' => 'usuario registrador',
        ];
    }
}