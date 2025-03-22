<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'total_compra' => 'required|numeric',
            'descuento_compra' => 'nullable|numeric',
            'estado_compra' => 'nullable|in:pendiente,pagado,cancelado',
            'estado' => 'required|in:activo,inactivo',
            'registradopor' => 'required|exists:users,id',

            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.subtotal' => 'required|numeric|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'proveedor_id' => 'proveedor',
            'fecha_compra' => 'fecha de la compra',
            'total_compra' => 'total de la compra',
            'descuento_compra' => 'descuento de la compra',
            'estado_compra' => 'estado de la compra',
            'estado' => 'estado',
            'registradopor' => 'usuario que registró',

            'detalles' => 'productos de la compra',
            'detalles.*.producto_id' => 'producto',
            'detalles.*.cantidad' => 'cantidad del producto',
            'detalles.*.precio_unitario' => 'precio unitario del producto',
            'detalles.*.subtotal' => 'subtotal del producto',
        ];
    }

    public function messages()
    {
        return [
            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.exists' => 'El proveedor seleccionado no existe.',
            'fecha_compra.required' => 'La fecha de la compra es obligatoria.',
            'fecha_compra.date' => 'La fecha de la compra debe ser una fecha válida.',
            'total_compra.required' => 'El total de la compra es obligatorio.',
            'total_compra.numeric' => 'El total de la compra debe ser un número.',
            'descuento_compra.numeric' => 'El descuento de la compra debe ser un número.',
            'estado_compra.in' => 'El estado de la compra debe ser "pendiente", "pagado" o "cancelado".',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'registradopor.required' => 'El campo "registrado por" es obligatorio.',
            'registradopor.exists' => 'El usuario que registró la compra no es válido.',

            'detalles.required' => 'Debe agregar al menos un producto a la compra.',
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
