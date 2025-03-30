<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // Listar productos (index)
    public function index()
    {
        $productos = Producto::with('categoria')
            ->where('estado', 1)
            ->where('stock', '>', 0)
            ->select('id', 'nombre', 'descripcion', 'precio', 'stock', 'img', 'categoria_id')
            ->get();

        // Formatear respuesta
        $productos = $productos->map(function ($producto) {
            // Modificar la forma en que se devuelve la URL de la imagen
            $imageUrl = $producto->img ? url('productos/' . basename($producto->img) . '/imagen') : null;
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'img' => $imageUrl, // Utiliza la ruta correcta para acceder a la imagen
                'categoria' => $producto->categoria->nombre ?? null,
            ];
        });

        return response()->json($productos);
    }

    // Ver detalles de un producto por ID (show)
    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        // Obtener la URL de la imagen
        $imageUrl = $producto->img ? url('productos/' . basename($producto->img) . '/imagen') : null;

        return response()->json([
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'img' => $imageUrl, // Devuelve la URL de la imagen en el formato correcto
            'categoria' => $producto->categoria->nombre ?? null,
        ]);
    }

    // Mostrar la imagen del producto
    public function mostrarImagen($filename)
    {
        $path = 'productos/' . $filename;

        try {
            // Intenta obtener la imagen desde S3
            $file = Storage::disk('s3')->get($path);
            $mime = Storage::disk('s3')->mimeType($path);

            return response($file, 200)->header('Content-Type', $mime);
        } catch (\Exception $e) {
            \Log::error("Error al obtener imagen de producto '{$path}': " . $e->getMessage());

            return response()->json([
                'error' => 'No se pudo acceder a la imagen del producto.',
                'mensaje' => $e->getMessage(),
                'path' => $path
            ], 404);
        }
    }
}

