<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Especificamos la tabla asociada al modelo
    protected $table = 'ventas';

    // Especificamos los atributos que son asignables masivamente
    protected $fillable = [
        'cliente_id',
        'fecha_venta',
        'total_venta',
        'descuento_venta',
        'estado_venta',
        'estado',
        'registradopor',
        'producto_id',
        'cantidad_producto',
        'precio_unitario_producto',
        'subtotal',
    ];

    // Especificamos los tipos de datos de las columnas para evitar problemas con la conversión de tipos
    protected $casts = [
        'fecha_venta' => 'datetime', // Convierte la fecha de la venta a un objeto Carbon
        'total_venta' => 'decimal:2',
        'descuento_venta' => 'decimal:2',
        'precio_unitario_producto' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con el modelo User (quien registró la venta)
    public function registrador()
    {
        return $this->belongsTo(User::class, 'registradopor');
    }
}
