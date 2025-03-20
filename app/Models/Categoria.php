<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
	
	protected $fillable = [
        'nombre','descripcion','estado','registradopor',
    ];
	
	protected $guarded = [
        'estado','registradopor',
    ];

    public function productos()
    {
        return $this->hasMany('App\Models\Producto', 'categoria_id');
    }
}