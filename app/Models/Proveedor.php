<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Definir la tabla que el modelo utilizará
    protected $table = 'proveedores';

    // Definir los campos que son asignables
    protected $fillable = [
        'nombre',
        'cedula',
        'email',
        'telefono',
        'direccion',
        'estado',
        'registradopor',
    ];

    // Definir los campos que no deberían ser asignables
    protected $guarded = [];

    // Si los campos `created_at` y `updated_at` se gestionan de forma personalizada, descomentarlos:
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';

    // Si necesitas configurar algún tipo de relación con otros modelos, puedes agregarlo aquí.
    // Ejemplo: Relación con el usuario que registró el proveedor (suponiendo que tienes un modelo de Usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'registradopor');
    }
}
