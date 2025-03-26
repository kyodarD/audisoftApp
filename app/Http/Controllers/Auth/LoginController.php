<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Este método se ejecuta justo después del login exitoso.
     */
    protected function authenticated($request, $user)
    {
        // Limpiar caché de permisos y roles
        $user->forgetCachedPermissions();

        // Recargar el usuario con relaciones
        auth()->setUser($user->fresh()->load('roles', 'permissions'));

        // Buscar el primer permiso que comience con "ver "
        foreach ($user->getAllPermissions() as $permiso) {
            if (str_starts_with($permiso->name, 'ver ')) {
                // Extraer el nombre del recurso, por ejemplo "ver compras" => "compras"
                $recurso = str_replace('ver ', '', $permiso->name);
                return redirect("/$recurso");
            }
        }

        // Si no tiene ningún permiso que empiece por "ver", lo mandamos a una vista segura
        return redirect('/home');
    }
}
