<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor'])->get(); // Relación con categorías y proveedores
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::where('estado', '=', '1')->orderBy('nombre')->get();
        $proveedores = Proveedor::where('estado', '=', 'activo')->orderBy('nombre')->get(); // Proveedores activos
        return view('productos.create', compact('categorias', 'proveedores'));
    }

    public function store(ProductoRequest $request)
    {
        try {
            $image = $request->file('img');
            $slug = Str::slug($request->nombre);

            if (isset($image)) {
                $currentDate = Carbon::now()->toDateString();
                $imagename = $slug . '-' . $currentDate . '.' . $image->getClientOriginalExtension();

                if (!file_exists('uploads/productos')) {
                    mkdir('uploads/productos', 0777, true);
                }
                $image->move('uploads/productos', $imagename);
            } else {
                $imagename = "";
            }

            Producto::create(array_merge($request->all(), ['img' => $imagename]));
            return redirect()->route('productos.index')->with('successMsg', 'El registro se guardó exitosamente');
        } catch (Exception $e) {
            Log::error('Error al guardar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error al guardar el producto. Inténtelo nuevamente.');
        }
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all(); // Obtener todos los proveedores
        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        try {
            $image = $request->file('img');
            $slug = Str::slug($request->nombre);

            if (isset($image)) {
                $currentDate = Carbon::now()->toDateString();
                $imagename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

                if (!file_exists('uploads/productos')) {
                    mkdir('uploads/productos', 0777, true);
                }
                $image->move('uploads/productos', $imagename);
            } else {
                $imagename = $producto->img;
            }

            $producto->update(array_merge($request->all(), ['img' => $imagename]));
            return redirect()->route('productos.index')->with('successMsg', 'El registro se actualizó exitosamente');
        } catch (Exception $e) {
            Log::error('Error al actualizar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error al actualizar el producto. Inténtelo nuevamente.');
        }
    }

    public function show(Producto $producto)
{
    try {
        return view('productos.show', compact('producto'));
    } catch (Exception $e) {
        Log::error('Error al mostrar el producto: ' . $e->getMessage());
        return redirect()->route('productos.index')->withErrors('No se pudo mostrar el detalle del producto.');
    }
}


    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();
            return redirect()->route('productos.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('El registro tiene información relacionada. Comuníquese con el Administrador.');
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador.');
        }
    }

    public function getInfo($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'precio' => $producto->precio,
            'stock' => $producto->stock,
        ]);
    }



    public function cambioestadoproducto(Request $request)
    {
        try {
            $producto = Producto::findOrFail($request->id);
            $producto->estado = $request->estado;
            $producto->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al cambiar el estado del producto: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}
