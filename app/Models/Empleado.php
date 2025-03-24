<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cedula',
        'telefono',
        'email',
        'direccion',
        'cargo',
        'salario',
        'estado',
        'pais_id',
        'departamento_id',
        'ciudad_id',
        'user_id',
        'registradopor',
        'role_id',
        'photo',
    ];

    // Relación con usuario asignado al empleado
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el usuario que registró al empleado
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registradopor');
    }

    // Relación con rol
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relación con ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    // Relación con departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    // Relación con país
    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }
}
