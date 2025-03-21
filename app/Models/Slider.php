<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 
        'descripcion', 
        'img', 
        'registrado_por'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}