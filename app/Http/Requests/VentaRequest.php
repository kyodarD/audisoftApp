<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permite el acceso a todos los usuarios
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) { // Reglas para crear una nueva venta
            return [
                'cliente_id' => 'required|exists:clientes,id', // El cliente debe existir en la tabla 'clientes'
                'fecha_venta' => 'required|date', // Fecha de la venta debe ser válida
                'total_venta' => 'required|numeric', // Total de la venta debe ser un número
                'descuento_venta' => 'nullable|numeric', // Descuento de la venta (opcional)
                'estado_venta' => 'nullable|in:pendiente,pagado', // Validación para estado_venta (Pendiente o Pagado)
                'estado' => 'required|in:activo,inactivo', // Estado de la venta (activo o inactivo)
                'registradopor' => 'required|exists:users,id', // ID del usuario que registró la venta
                'producto_id' => 'required|exists:productos,id', // El producto debe existir en la tabla 'productos'
                'cantidad_producto' => 'required|integer|min:1', // Cantidad mínima 1
                'precio_unitario_producto' => 'required|numeric|min:0', // Precio unitario no puede ser negativo
                'subtotal' => 'required|numeric|min:0', // Subtotal no puede ser negativo
            ];
        } elseif ($this->isMethod('put')) { // Reglas para actualizar una venta
            return [
                'cliente_id' => 'required|exists:clientes,id', // El cliente debe existir en la tabla 'clientes'
                'fecha_venta' => 'required|date', // Fecha de la venta debe ser válida
                'total_venta' => 'required|numeric', // Total de la venta debe ser un número
                'descuento_venta' => 'nullable|numeric', // Descuento de la venta (opcional)
                'estado_venta' => 'nullable|in:pendiente,pagado', // Validación para estado_venta (Pendiente o Pagado)
                'estado' => 'required|in:activo,inactivo', // Estado de la venta (activo o inactivo)
                'registradopor' => 'nullable|exists:users,id', // ID del usuario que registró la venta (opcional en actualización)
                'producto_id' => 'nullable|exists:productos,id', // El producto debe existir en la tabla 'productos' (opcional en actualización)
                'cantidad_producto' => 'nullable|integer|min:1', // Cantidad mínima 1 (opcional en actualización)
                'precio_unitario_producto' => 'nullable|numeric|min:0', // Precio unitario no puede ser negativo (opcional en actualización)
                'subtotal' => 'nullable|numeric|min:0', // Subtotal no puede ser negativo (opcional en actualización)
            ];
        }

        return [];
    }

    public function attributes()
    {
        return [
            'cliente_id' => 'cliente',
            'fecha_venta' => 'fecha de la venta',
            'total_venta' => 'total de la venta',
            'descuento_venta' => 'descuento de la venta',
            'estado_venta' => 'estado de la venta',
            'estado' => 'estado', // Este es el estado de la venta
            'registradopor' => 'usuario que registró', // Este es el nombre del usuario que registró la venta
            'producto_id' => 'producto',
            'cantidad_producto' => 'cantidad del producto',
            'precio_unitario_producto' => 'precio unitario del producto',
            'subtotal' => 'subtotal del producto',
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
            'estado_venta.in' => 'El estado de la venta debe ser "pendiente" o "pagado".', // Mensaje para validación de estado_venta
            'estado.required' => 'El estado de la venta es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'registradopor.required' => 'El campo "registrado por" es obligatorio al crear una venta.',
            'registradopor.exists' => 'El usuario que registró la venta no es válido.',
            'producto_id.required' => 'El producto es obligatorio.',
            'producto_id.exists' => 'El producto seleccionado no existe.',
            'cantidad_producto.required' => 'La cantidad del producto es obligatoria.',
            'cantidad_producto.integer' => 'La cantidad del producto debe ser un número entero.',
            'cantidad_producto.min' => 'La cantidad del producto debe ser al menos 1.',
            'precio_unitario_producto.required' => 'El precio unitario del producto es obligatorio.',
            'precio_unitario_producto.numeric' => 'El precio unitario del producto debe ser un número.',
            'precio_unitario_producto.min' => 'El precio unitario del producto debe ser al menos 0.',
            'subtotal.required' => 'El subtotal del producto es obligatorio.',
            'subtotal.numeric' => 'El subtotal del producto debe ser un número.',
            'subtotal.min' => 'El subtotal del producto no puede ser negativo.',
        ];
    }
}
