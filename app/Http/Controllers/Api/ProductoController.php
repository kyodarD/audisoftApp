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
            $imageUrl = $producto->img ? route('imagen.producto', ['filename' => basename($producto->img)]) : null;
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'img' => $imageUrl, // Utiliza la ruta para acceder a la imagen
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
        $imageUrl = $producto->img ? route('imagen.producto', ['filename' => basename($producto->img)]) : null;

        return response()->json([
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'img' => $imageUrl, // Devuelve la URL de la imagen
            'categoria' => $producto->categoria->nombre ?? null,
        ]);
    }

    // Mostrar la imagen del producto
    public function mostrarImagen($filename)
    {
        $path = 'productos/' . $filename;

        try {
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

    // Crear un nuevo producto (store)
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio'      => 'required|numeric',
            'stock'       => 'required|integer',
            'img'         => 'required|string',
            'categoria_id'=> 'required|integer|exists:categorias,id',
        ]);

        $producto = Producto::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'stock'       => $request->stock,
            'img'         => $request->img,  // Aquí asumo que `img` es solo una URL o nombre de archivo
            'categoria_id'=> $request->categoria_id,
            'estado'      => 1  // Por defecto, el producto está activo
        ]);

        return response()->json([
            'mensaje' => 'Producto creado correctamente',
            'producto' => $producto
        ], 201);
    }

    // Actualizar un producto (update)
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        // Validación de los datos
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio'      => 'required|numeric',
            'stock'       => 'required|integer',
            'img'         => 'nullable|string',
            'categoria_id'=> 'required|integer|exists:categorias,id',
        ]);

        // Actualizar los datos del producto
        $producto->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'stock'       => $request->stock,
            'img'         => $request->img ?? $producto->img,  // Si no se pasa una imagen, se deja la original
            'categoria_id'=> $request->categoria_id,
        ]);

        return response()->json([
            'mensaje' => 'Producto actualizado correctamente',
            'producto' => $producto
        ]);
    }

    // Eliminar un producto (destroy)
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado correctamente']);
    }
}
