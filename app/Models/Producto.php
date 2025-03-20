<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
	
	protected $fillable = [
        'proveedor_id',
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'fecha_vencimiento',
        'img','estado',
        'registradopor',
    ];
	
	protected $guarded = [
        'estado','registradopor',
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
       
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    
}
