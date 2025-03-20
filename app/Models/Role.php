<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permission; // 🔹 Importar correctamente
use App\Models\User; // 🔹 Importar User, si no está importado

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'description'];

    // Relación muchos a muchos con permisos
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    // Relación muchos a muchos con usuarios
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')
                    ->where('model_type', 'App\Models\User');  // Asegura que solo se asignen roles a usuarios
    }
}
