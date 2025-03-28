<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'titulo' => 'required',
            'descripcion' => 'required',
            'img' => 'required|image',
        ];
    }
}
