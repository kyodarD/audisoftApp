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
        // Proteger las rutas necesarias
        $this->middleware('auth')->except('verify');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Método sobrescrito para verificar el correo, activar estado y redirigir según el rol.
     */
    public function verify(Request $request)
    {
        // Obtener el usuario desde la ruta
        $user = User::findOrFail($request->route('id'));

        // Validar que el hash sea válido
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'El enlace de verificación no es válido.');
        }

        // Si ya está verificado, solo loguear y redirigir
        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect($this->determineRedirect($user))->with('verified', true);
        }

        // Marcar como verificado
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            $user->estado = 1; // Activar usuario
            $user->save();

            $user->forgetCachedPermissions(); // Limpiar permisos cacheados si usas Spatie

            Auth::login($user); // Login automático
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
