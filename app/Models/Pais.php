<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
	
	protected $fillable = [
        'nombre','estado','registradopor',
    ];
	
	protected $guarded = [
        'estado','registradopor',
    ];

    public function departamentos()
    {
        return $this->hasMany('App\Models\Departamento', 'pais_id');
    }
}