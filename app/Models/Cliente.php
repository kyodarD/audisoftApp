<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';  
    protected $fillable = [
        'nombre',
        'cedula',
        'direccion',
        'telefono',
        'email',
        'estado',
        'registradopor',
    ];

    protected $guarded = [
        'estado', 
        'registradopor',
    ];


    public function ventas()
    {
        return $this->hasMany('App\Models\Venta', 'cliente_id'); 
    }
}
