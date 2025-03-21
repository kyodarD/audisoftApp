<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::where('id', Auth::id())->where('estado', 1)->first();
		if (!$user) {
			Auth::logout();
            return redirect()->route('welcome')->withErrors('Tus datos de acceso: usuario y contraseña no se encuentran registrados o se encuentran
			inactivos para el ingreso al sistema. Debes registrarte primero o comunícarte con el Administrador.');
        }
        return view('home',compact('user'));
    }
}
