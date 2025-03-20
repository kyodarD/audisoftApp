<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Override del método verify para actualizar el estado del usuario.
     */
    public function verify(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath())->with('verified', true);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Actualiza el estado del usuario a 1
            $user->estado = 1;
            $user->save();
        }

        return redirect($this->redirectPath())->with('verified', true);
    }
}
