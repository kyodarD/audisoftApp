<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'fecha_venta',
        'total_venta',
        'descuento_venta',
        'estado_venta',
        'estado',
        'registradopor',
    ];

    protected $casts = [
        'fecha_venta' => 'datetime',
        'total_venta' => 'decimal:2',
        'descuento_venta' => 'decimal:2',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con el usuario que registró la venta
    public function registrador()
    {
        return $this->belongsTo(User::class, 'registradopor');
    }

    // Relación con los detalles de la venta (productos vendidos)
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}
