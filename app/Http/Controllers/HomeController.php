<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Compra;
use App\Models\Venta;
use App\Traits\HasPermissionMiddleware;

class HomeController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('dashboard');
    }

    public function index()
    {
        $user = User::where('id', Auth::id())->where('estado', 1)->first();

        if (!$user) {
            Auth::logout();
            return redirect()->route('welcome')->withErrors(
                'Tus datos de acceso: usuario y contraseña no se encuentran registrados o se encuentran inactivos para el ingreso al sistema. Debes registrarte primero o comunícarte con el Administrador.'
            );
        }

        // Contadores para el dashboard
        $clientesCount = Cliente::count();
        $proveedoresCount = Proveedor::count();
        $comprasCount = Compra::count();
        $ventasCount = Venta::count();

        return view('home', compact('user', 'clientesCount', 'proveedoresCount', 'comprasCount', 'ventasCount'));
    }
}
