<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->isMethod('post')) {
            return [
                'categoria_id' => 'required',
                'descripcion' => 'nullable',
                'precio' => 'required',
                'stock' => 'required',
                'fecha_vencimiento' => 'required',
                'img' => 'nullable|mimes:jpg,jpeg,png|max:7000',
                'nombre' => 'required|unique:productos,nombre|regex:/^[\pL\s\-]+$/u'
            ];    
        } elseif (request()->isMethod('put')) {
            return [
                'descripcion' => 'nullable',
                'precio' => 'required',
                'stock' => 'required',
                'fecha_vencimiento' => 'required',
                'img' => 'nullable|mimes:jpg,jpeg,png|max:7000',
                'nombre' => 'required|regex:/^[\pL\s\-]+$/u'
            ];
        }

        // Retorno predeterminado para otros métodos HTTP
        return [];
    }

    public function attributes()
    {
        return [
            'categoria_id' => 'categoria',
            'proveedor_id' => 'proveedor'

        ];
    }
}
