<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validar los datos de registro.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crear al usuario.
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('cliente');
        $user->forgetCachedPermissions();

        return $user;
    }

    /**
     * Después de registrar, dispara el evento de verificación por correo.
     */
    protected function registered($request, $user)
    {
        //  Envía el correo de verificación
        event(new Registered($user));

        return redirect($this->redirectPath())
            ->with('success', 'Por favor verifica tu correo electrónico.');
    }
}
