<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrusel;
use Illuminate\Support\Str;
use Image;
use Illuminate\Database\QueryException;
use Exception;
use App\Traits\HasPermissionMiddleware;

class CarruselController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        // Aplica permisos por acción para la sección "carrusels"
        $this->applyPermissionMiddleware('carrusels');
    }

    public function index()
    {
        $carrusels = Carrusel::all();
        return view('carrusels.index', compact('carrusels'));
    }

    public function create()
    {
        // Normalmente mostraría un formulario distinto, pero por tu código 
        // devuelves la misma vista 'carrusels.index'
        return view('carrusels.index');
    }

    public function store(Request $request)
    {
        // Aquí, de nuevo, devuelves la misma vista 'carrusels.index'
        // Lógica adicional de guardado podría ir aquí
        return view('carrusels.index');
    }

    public function update(Request $request, $id)
    {
        // De nuevo, retornas la misma vista
        return view('carrusels.index');
    }

    public function show($id)
    {
        return view('carrusels.index');
    }

    public function destroy($id)
    {
        // Corregimos el nombre del método y, de nuevo, misma vista
        return view('carrusels.index');
    }
}
