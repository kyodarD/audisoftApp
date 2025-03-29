<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class VerificationController extends Controller
{
    use VerifiesEmails;

    // Redirección por defecto
    protected $redirectTo = '/home';

    public function __construct()
    {
        // ✅ NO requerimos 'auth' para 'verify'
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Método sobrescrito para verificar el correo, activar estado y redirigir según el rol.
     */
    public function verify(Request $request)
    {
        // Obtener el usuario desde la ruta (sin necesidad de estar logueado)
        $user = User::findOrFail($request->route('id'));

        // Verificación del hash
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            Log::warning('Hash inválido al verificar email para usuario ID ' . $user->id);
            abort(403, 'El enlace de verificación no es válido.');
        }

        // Si ya está verificado, loguear y redirigir
        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect($this->determineRedirect($user))->with('verified', true);
        }

        // Verificar el correo
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Activar usuario y limpiar permisos (si usas Spatie)
            $user->estado = 1;
            $user->save();
            $user->forgetCachedPermissions();

            // Login automático después de verificar
            Auth::login($user);
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
