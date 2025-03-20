<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles; // Agregar el trait para manejar roles y permisos

class Empleado extends Model
{
    use HasRoles; // Usar el trait de Spatie para asignar roles y permisos

    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'cedula',
        'telefono',
        'email',
        'direccion',
        'cargo',
        'salario',
        'estado',
        'registradopor',
        'user_id', // Relación con la tabla users
        'photo', // Para la imagen del empleado
    ];

    protected $guarded = [];

    /**
     * Relación con el modelo Usuario.
     * Un empleado pertenece a un usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Relación con el modelo Venta.
     * Un empleado puede tener muchas ventas.
     */
    public function ventas(): HasMany
    {
        return $this->hasMany('App\Models\Venta', 'empleado_id');
    }

    /**
     * Relación con el modelo User (registradopor).
     * Un empleado es registrado por un usuario (admin).
     */
    public function registrador(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'registradopor');
    }

    /**
     * Relación con los roles (Spatie).
     * Un empleado puede tener varios roles.
     */
    public function roles()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'model_has_roles', 'model_id', 'role_id')
                    ->where('model_type', Empleado::class); // Asegura que el model_type sea Empleado
    }
}
