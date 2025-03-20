<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles; // Ya usas el trait HasRoles de Spatie para manejar roles y permisos

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',  // Asegúrate de que 'photo' esté aquí
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Asegúrate de que tu versión de Laravel y el método de hash coincidan
    ];

    // Accesor para la URL de la foto, si la foto existe, devuelve la URL pública
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::url($this->photo); // Retorna la URL pública de la imagen
        }

        return null; // Si no hay foto, retorna null
    }

    // Mutador para manejar el almacenamiento de la foto (opcional)
    public function setPhotoAttribute($value)
    {
        if (is_file($value)) {
            // Si el valor es un archivo, almacénalo en la carpeta 'photos' del disco público
            $this->attributes['photo'] = $value->store('photos', 'public');
        } else {
            // Si no es un archivo, simplemente se almacena el valor
            $this->attributes['photo'] = $value;
        }
    }
}
