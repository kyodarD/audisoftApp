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
     * Redirige al usuario autenticado según su rol.
     */
    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->hasRole('super-admin')) {
            return '/home';
        }

        if ($user->hasRole('vendedor')) {
            return '/compras';
        }

        if ($user->hasRole('cliente')) {
            return '/ventas';
        }

        return '/home';
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
    }
}
