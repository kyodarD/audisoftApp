<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Http\Requests\VentaRequest;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('ventas.index', compact('ventas', 'clientes', 'productos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(VentaRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated['registradopor'] = auth()->id();

            // Crear la venta principal
            $venta = Venta::create([
                'cliente_id' => $validated['cliente_id'],
                'fecha_venta' => $validated['fecha_venta'],
                'total_venta' => $validated['total_venta'],
                'descuento_venta' => $validated['descuento_venta'] ?? 0,
                'estado_venta' => $validated['estado_venta'] ?? 'pendiente',
                'estado' => $validated['estado'],
                'registradopor' => $validated['registradopor'],
            ]);

            // Guardar los detalles de productos
            foreach ($validated['detalles'] as $detalle) {
                $venta->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal'],
                    'registradopor' => $validated['registradopor'],
                ]);

                // Reducir el stock del producto
                Producto::where('id', $detalle['producto_id'])->decrement('stock', $detalle['cantidad']);
            }

            DB::commit();

            return redirect()->route('ventas.index')->with('successMsg', 'La venta se registró exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.index')->withErrors('Ocurrió un error al guardar la venta. Inténtelo nuevamente.');
        }
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(VentaRequest $request, Venta $venta)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $venta->update([
                'cliente_id' => $validated['cliente_id'],
                'fecha_venta' => $validated['fecha_venta'],
                'total_venta' => $validated['total_venta'],
                'descuento_venta' => $validated['descuento_venta'] ?? 0,
                'estado_venta' => $validated['estado_venta'] ?? 'pendiente',
                'estado' => $validated['estado'],
            ]);

            // Eliminar detalles antiguos (si quieres actualizar completamente)
            $venta->detalles()->delete();

            // Volver a crear los nuevos detalles
            foreach ($validated['detalles'] as $detalle) {
                $venta->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal'],
                    'registradopor' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('ventas.index')->with('successMsg', 'La venta se actualizó exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.index')->withErrors('Ocurrió un error al actualizar la venta. Inténtelo nuevamente.');
        }
    }

    public function destroy(Venta $venta)
    {
        try {
            $venta->delete();
            return redirect()->route('ventas.index')->with('successMsg', 'La venta se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.index')->withErrors('La venta tiene información relacionada. Comuníquese con el Administrador.');
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.index')->withErrors('Ocurrió un error inesperado. Comuníquese con el Administrador.');
        }
    }

    public function show($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);

        return view('ventas.show', compact('venta'));
    }

    public function cambioEstadoVenta(Request $request)
    {
        try {
            $venta = Venta::findOrFail($request->id);

            $request->validate([
                'estado_venta' => 'nullable|in:pendiente,pagado',
            ]);

            $venta->estado_venta = $request->estado_venta;
            $venta->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al cambiar el estado de la venta: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}
