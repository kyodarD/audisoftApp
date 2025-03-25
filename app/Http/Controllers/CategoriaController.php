<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Traits\HasPermissionMiddleware;

class CategoriaController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('categorias');
    }

    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(CategoriaRequest $request)
    {
        Categoria::create($request->all());
        return redirect()->route('categorias.index')->with('successMsg','El registro se guardó exitosamente');
    }

    public function show(Categoria $categoria)
    {
        // Si no lo usas, puedes dejarlo vacío o eliminarlo si no lo llamas en las rutas.
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->all());
        return redirect()->route('categorias.index')->with('successMsg','El registro se actualizó exitosamente');
    }

    public function destroy(Categoria $categoria)
    {
        try {
            $categoria->delete();
            return redirect()->route('categorias.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar la categoría: ' . $e->getMessage());
            return redirect()->route('categorias.index')
                ->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar la categoría: ' . $e->getMessage());
            return redirect()->route('categorias.index')
                ->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }

    public function cambioestadocategoria(Request $request)
    {
        $categoria = Categoria::find($request->id);
        $categoria->estado = $request->estado;
        $categoria->save();
    }
}
