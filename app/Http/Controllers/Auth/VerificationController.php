<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerificationController extends Controller
{
    use VerifiesEmails;

    // Redirección por defecto
    protected $redirectTo = '/home'; 

    public function __construct()
    {
        // Solo proteger rutas específicas
        $this->middleware('auth')->except('verify');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Método sobrescrito para verificar el correo, activar estado y redirigir según el rol.
     */
    public function verify(Request $request)
    {
        // Buscar al usuario por el ID incluido en la URL firmada
        $user = User::findOrFail($request->route('id'));

        // Verificar si ya ha verificado su correo
        if ($user->hasVerifiedEmail()) {
            Auth::login($user); // Login automático
            return redirect($this->determineRedirect($user))->with('verified', true);
        }

        // Marcar el correo como verificado
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Activar estado y limpiar permisos
            $user->estado = 1;
            $user->save();
            $user->forgetCachedPermissions();

            Auth::login($user); // Login automático
        }

        // Redirigir a la página correspondiente después de la verificación
        return redirect($this->determineRedirect($user))->with('verified', true);
    }

    /**
     * Redirección dinámica según el rol del usuario.
     */
    protected function determineRedirect($user)
    {
        if ($user->hasRole('cliente')) {
            return '/ventas';
        }

        // Redirección por defecto
        return $this->redirectTo;
    }
}
