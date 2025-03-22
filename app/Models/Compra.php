<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'proveedor_id',
        'fecha_compra',
        'total_compra',
        'descuento_compra',
        'estado_compra',
        'estado',
        'registradopor',
    ];

    protected $casts = [
        'fecha_compra' => 'datetime',
        'total_compra' => 'decimal:2',
        'descuento_compra' => 'decimal:2',
    ];

    // Relación con el proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con el usuario que registró la compra
    public function registrador()
    {
        return $this->belongsTo(User::class, 'registradopor');
    }

    // Relación con los detalles de la compra (productos comprados)
    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'compra_id');
    }
}
