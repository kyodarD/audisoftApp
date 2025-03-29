<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    use VerifiesEmails;

    // Redirección por defecto
    protected $redirectTo = '/home'; 

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Método sobrescrito para verificar el correo, activar estado y redirigir según el rol.
     */
    public function verify(Request $request)
    {
        $user = $request->user();

        // Verificar si ya ha verificado su correo
        if ($user->hasVerifiedEmail()) {
            return redirect($this->determineRedirect($user))->with('verified', true);
        }

        // Si no está verificado, marca el correo como verificado
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Activar estado y limpiar permisos
            $user->estado = 1;
            $user->save();
            $user->forgetCachedPermissions();
        }

        // Redirigir a la página correspondiente después de la verificación
        return redirect($this->determineRedirect($user))->with('verified', true);
    }

    /**
     * Redirección dinámica según el rol del usuario.
     */
    protected function determineRedirect($user)
    {
        // Si el usuario tiene rol de cliente, lo redirige a la página de ventas
        if ($user->hasRole('cliente')) {
            return '/ventas';
        }

        // Redirección por defecto
        return $this->redirectTo;
    }
}
