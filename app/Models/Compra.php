<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_compra',
        'fecha_compra',
        'estado',
        'registradopor',
        'cliente_id', // Agregado para permitir asignar el cliente asociado
    ];

    // Relación muchos a muchos con productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compra_producto')
                    ->withPivot('cantidad_producto', 'precio_unitario_producto')
                    ->withTimestamps();
    }

    // Relación con el usuario que registró la compra
    public function usuario()
    {
        return $this->belongsTo(User::class, 'registradopor');
    }

    // Nueva relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id'); // Asociar la columna cliente_id con el modelo Cliente
    }
}