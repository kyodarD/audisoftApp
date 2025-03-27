<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente', 'detalles.producto')->get();
        return response()->json($ventas);
    }

    public function show($id)
    {
        $venta = Venta::with('cliente', 'detalles.producto')->find($id);

        if (!$venta) {
            return response()->json(['mensaje' => 'Venta no encontrada'], 404);
        }

        return response()->json($venta);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_venta' => 'required|date',
            'total_venta' => 'required|numeric',
            'descuento_venta' => 'nullable|numeric',
            'estado_venta' => 'nullable|in:pendiente,pagado',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.subtotal' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha_venta' => $request->fecha_venta,
                'total_venta' => $request->total_venta,
                'descuento_venta' => $request->descuento_venta ?? 0,
                'estado_venta' => $request->estado_venta ?? 'pendiente',
                'estado' => 'activo',
                'registradopor' => auth()->id() ?? 1 // opcional: manejar sin login aún
            ]);

            foreach ($request->detalles as $detalle) {
                $venta->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal'],
                    'registradopor' => auth()->id() ?? 1
                ]);

                Producto::where('id', $detalle['producto_id'])->decrement('stock', $detalle['cantidad']);
            }

            DB::commit();

            return response()->json([
                'mensaje' => 'Venta registrada correctamente',
                'venta' => $venta->load('detalles.producto')
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar venta por API: ' . $e->getMessage());
            return response()->json(['mensaje' => 'Ocurrió un error al guardar la venta'], 500);
        }
   
   
    }



}
