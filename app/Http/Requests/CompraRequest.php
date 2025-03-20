<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir cualquier usuario hacer la solicitud
    }

    public function rules()
    {
        return [
            'total_compra' => 'required|numeric|min:0', // Asegúrate de que el total sea un número no negativo
            'fecha_compra' => 'required|date', // Asegúrate de que la fecha sea válida
            'cliente_id' => 'required|exists:clientes,id', // Asegúrate de que el cliente exista
            'productos' => 'required|array', // Asegúrate de que 'productos' sea un array
            'productos.*.id' => 'required|exists:productos,id', // Cada producto debe existir
            'productos.*.cantidad' => 'required|integer|min:1', // La cantidad debe ser un número entero mayor o igual a 1
        ];
    }
}