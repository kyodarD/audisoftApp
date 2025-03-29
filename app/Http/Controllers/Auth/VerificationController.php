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

    protected $redirectTo = '/home';

    public function __construct()
    {
        // No requerimos auth para verify (porque viene del correo)
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        // Validar el hash con el email directamente
        if (! hash_equals((string) $request->route('hash'), sha1($user->email))) {
            abort(403, 'El enlace de verificación no es válido.');
        }

        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect($this->determineRedirect($user))->with('verified', true);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            $user->estado = 1;
            $user->save();

            $user->forgetCachedPermissions();
            Auth::login($user);
        }

        return redirect($this->determineRedirect($user))->with('verified', true);
    }

    protected function determineRedirect($user)
    {
        if ($user->hasRole('cliente')) {
            return '/ventas';
        }

        return $this->redirectTo;
    }
}
