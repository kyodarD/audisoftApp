<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->isMethod('post')) {
            return [
                'nombre' => 'required|unique:categorias,nombre|regex:/^[\pL\s\-]+$/u'
            ];    
        } elseif (request()->isMethod('put')) {
            return [
                'nombre' => 'required|regex:/^[\pL\s\-]+$/u'
            ];
        }

        // Retorno predeterminado para otros métodos HTTP
        return [];
    }
}
