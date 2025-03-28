<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/home'; // ruta por defecto para otros roles

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

        if ($user->hasVerifiedEmail()) {
            return redirect($this->determineRedirect($user))->with('verified', true);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Activar estado y limpiar permisos
            $user->estado = 1;
            $user->save();
            $user->forgetCachedPermissions();
        }

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

        return $this->redirectTo;
    }
}
