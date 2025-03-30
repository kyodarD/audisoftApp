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
use Illuminate\Support\Facades\Storage;
use App\Traits\HasPermissionMiddleware;

class ProductoController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('productos');
    }

    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor'])->get();

        foreach ($productos as $producto) {
            if ($producto->img) {
                $filename = basename($producto->img);
                $producto->public_url = route('imagen.producto', $filename);
            } else {
                $producto->public_url = null;
            }
        }

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::where('estado', '=', '1')->orderBy('nombre')->get();
        $proveedores = Proveedor::where('estado', '=', 'activo')->orderBy('nombre')->get();
        return view('productos.create', compact('categorias', 'proveedores'));
    }

    public function store(ProductoRequest $request)
    {
        try {
            $image = $request->file('img');
            $slug = Str::slug($request->nombre);
            $imagePath = null;

            if ($image) {
                $imagename = $slug . '-' . Carbon::now()->toDateString() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'productos/' . $imagename;

                try {
                    Storage::disk('s3')->put($path, file_get_contents($image), 'private');
                    Log::info("Imagen subida correctamente: {$path}");
                    $imagePath = $path;
                } catch (Exception $e) {
                    Log::error("Error al subir imagen: " . $e->getMessage());
                }
            }

            Producto::create(array_merge($request->all(), ['img' => $imagePath]));

            return redirect()->route('productos.index')->with('successMsg', 'El registro se guardó exitosamente');
        } catch (Exception $e) {
            Log::error('Error al guardar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error al guardar el producto. Inténtelo nuevamente.');
        }
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        try {
            $image = $request->file('img');
            $slug = Str::slug($request->nombre);
            $imagePath = $producto->img;

            if ($image) {
                $imagename = $slug . '-' . Carbon::now()->toDateString() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'productos/' . $imagename;

                try {
                    Storage::disk('s3')->put($path, file_get_contents($image), 'private');
                    Log::info("Imagen actualizada en S3: {$path}");
                    $imagePath = $path;
                } catch (Exception $e) {
                    Log::error("Error al actualizar imagen en S3: " . $e->getMessage());
                }
            }

            $producto->update(array_merge($request->all(), ['img' => $imagePath]));

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

    public function mostrarImagen($filename)
    {
        $path = 'productos/' . $filename;

        try {
            $file = Storage::disk('s3')->get($path);
            $mime = Storage::disk('s3')->mimeType($path);

            return response($file, 200)->header('Content-Type', $mime);
        } catch (Exception $e) {
            Log::error("Error al obtener imagen de producto '{$path}': " . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo acceder a la imagen del producto.',
                'mensaje' => $e->getMessage(),
                'path' => $path
            ], 404);
        }
    }
}
