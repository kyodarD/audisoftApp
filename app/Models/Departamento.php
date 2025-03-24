<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';

    protected $fillable = [
        'pais_id', 'nombre', 'codigo', 'estado', 'registradopor',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function ciudads()
    {
        return $this->hasMany(Ciudad::class, 'departamento_id');
    }
}
