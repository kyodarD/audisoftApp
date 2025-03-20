<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudads';
	
	protected $fillable = [
        'departamento_id','nombre','estado','registradopor',
    ];
	
	protected $guarded = [
        'estado','registradopor',
    ];

    public function departamento()
    {
        return $this->belongsTo('App\Models\Departamento');
    }
	
	public function institucions()
    {
        return $this->hasMany('App\Models\Institucion', 'ciudad_id');
    }
	
	public function personanacimientos()
    {
        return $this->hasMany('App\Models\Persona', 'ciudad_idnacimiento');
    }
	
	public function personaexpedicions()
    {
        return $this->hasMany('App\Models\Persona', 'ciudad_idexpedicion');
    }
	
	public function personaresidencias()
    {
        return $this->hasMany('App\Models\Persona', 'ciudad_idresidencia');
    }
}
