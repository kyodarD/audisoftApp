<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
	
	protected $fillable = [
        'pais_id','nombre','estado','registradopor',
    ];
	
	protected $guarded = [
        'estado','registradopor',
    ];

    public function pais()
    {
        return $this->belongsTo('App\Models\Pais');
    }

    public function ciudads()
    {
        return $this->hasMany('App\Models\Ciudad', 'departamento_id');
    }
}
