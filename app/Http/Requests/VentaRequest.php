<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_venta' => 'required|date',
            'total_venta' => 'required|numeric',
            'descuento_venta' => 'nullable|numeric',
            'estado_venta' => 'nullable|in:pendiente,pagado,cancelado',
            'estado' => 'required|in:activo,inactivo',
            'registradopor' => 'required|exists:users,id',

            // Validación para array de productos
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.subtotal' => 'required|numeric|min:0',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'cliente_id' => 'cliente',
            'fecha_venta' => 'fecha de la venta',
            'total_venta' => 'total de la venta',
            'descuento_venta' => 'descuento de la venta',
            'estado_venta' => 'estado de la venta',
            'estado' => 'estado',
            'registradopor' => 'usuario que registró',

            // Etiquetas personalizadas para los campos de los detalles
            'detalles' => 'productos de la venta',
            'detalles.*.producto_id' => 'producto',
            'detalles.*.cantidad' => 'cantidad del producto',
            'detalles.*.precio_unitario' => 'precio unitario del producto',
            'detalles.*.subtotal' => 'subtotal del producto',
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'fecha_venta.required' => 'La fecha de la venta es obligatoria.',
            'fecha_venta.date' => 'La fecha de la venta debe ser una fecha válida.',
            'total_venta.required' => 'El total de la venta es obligatorio.',
            'total_venta.numeric' => 'El total de la venta debe ser un número.',
            'descuento_venta.numeric' => 'El descuento de la venta debe ser un número.',
            'estado_venta.in' => 'El estado de la venta debe ser "pendiente", "pagado" o "cancelado".',
            'estado.required' => 'El estado de la venta es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'registradopor.required' => 'El campo "registrado por" es obligatorio.',
            'registradopor.exists' => 'El usuario que registró la venta no es válido.',

            // Mensajes para validaciones de productos
            'detalles.required' => 'Debe agregar al menos un producto a la venta.',
            'detalles.array' => 'El campo de productos debe ser un arreglo.',
            'detalles.*.producto_id.required' => 'El producto es obligatorio.',
            'detalles.*.producto_id.exists' => 'El producto seleccionado no existe.',
            'detalles.*.cantidad.required' => 'La cantidad del producto es obligatoria.',
            'detalles.*.cantidad.integer' => 'La cantidad del producto debe ser un número entero.',
            'detalles.*.cantidad.min' => 'La cantidad del producto debe ser al menos 1.',
            'detalles.*.precio_unitario.required' => 'El precio unitario del producto es obligatorio.',
            'detalles.*.precio_unitario.numeric' => 'El precio unitario debe ser un número.',
            'detalles.*.precio_unitario.min' => 'El precio unitario debe ser al menos 0.',
            'detalles.*.subtotal.required' => 'El subtotal del producto es obligatorio.',
            'detalles.*.subtotal.numeric' => 'El subtotal debe ser un número.',
            'detalles.*.subtotal.min' => 'El subtotal no puede ser negativo.',
        ];
    }
}
