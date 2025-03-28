<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->where('estado', 1)
            ->where('stock', '>', 0)
            ->select('id', 'nombre', 'descripcion', 'precio', 'stock', 'img', 'categoria_id')
            ->get();

        // Formatear respuesta
        $productos = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'img' => url('uploads/productos/' . $producto->img),
                'categoria' => $producto->categoria->nombre ?? null,
            ];
        });

        return response()->json($productos);
    }
}
