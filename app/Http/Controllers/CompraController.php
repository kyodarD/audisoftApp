<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\DetalleCompra;
use App\Http\Requests\CompraRequest;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('compras.index', compact('compras', 'proveedores', 'productos'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(CompraRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated['registradopor'] = auth()->id();

            $compra = Compra::create([
                'proveedor_id' => $validated['proveedor_id'],
                'fecha_compra' => $validated['fecha_compra'],
                'total_compra' => $validated['total_compra'],
                'descuento_compra' => $validated['descuento_compra'] ?? 0,
                'estado_compra' => $validated['estado_compra'] ?? 'pendiente',
                'estado' => $validated['estado'],
                'registradopor' => $validated['registradopor'],
            ]);

            foreach ($validated['detalles'] as $detalle) {
                $compra->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal'],
                    'registradopor' => $validated['registradopor'],
                ]);

                // Aumentar el stock del producto
                Producto::where('id', $detalle['producto_id'])->increment('stock', $detalle['cantidad']);
            }

            DB::commit();

            return redirect()->route('compras.index')->with('successMsg', 'La compra se registró exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar la compra: ' . $e->getMessage());
            return redirect()->route('compras.index')->withErrors('Ocurrió un error al guardar la compra. Inténtelo nuevamente.');
        }
    }

    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    public function update(CompraRequest $request, Compra $compra)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $compra->update([
                'proveedor_id' => $validated['proveedor_id'],
                'fecha_compra' => $validated['fecha_compra'],
                'total_compra' => $validated['total_compra'],
                'descuento_compra' => $validated['descuento_compra'] ?? 0,
                'estado_compra' => $validated['estado_compra'] ?? 'pendiente',
                'estado' => $validated['estado'],
            ]);

            // Eliminar detalles antiguos
            $compra->detalles()->delete();

            foreach ($validated['detalles'] as $detalle) {
                $compra->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal'],
                    'registradopor' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('compras.index')->with('successMsg', 'La compra se actualizó exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar la compra: ' . $e->getMessage());
            return redirect()->route('compras.index')->withErrors('Ocurrió un error al actualizar la compra. Inténtelo nuevamente.');
        }
    }

    public function destroy(Compra $compra)
    {
        try {
            $compra->delete();
            return redirect()->route('compras.index')->with('successMsg', 'La compra se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar la compra: ' . $e->getMessage());
            return redirect()->route('compras.index')->withErrors('La compra tiene información relacionada. Comuníquese con el Administrador.');
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar la compra: ' . $e->getMessage());
            return redirect()->route('compras.index')->withErrors('Ocurrió un error inesperado. Comuníquese con el Administrador.');
        }
    }

    public function show($id)
    {
        $compra = Compra::with('detalles.producto')->findOrFail($id);

        return view('compras.show', compact('compra'));
    }

    public function cambioEstadoCompra(Request $request)
    {
        try {
            $compra = Compra::findOrFail($request->id);

            $request->validate([
                'estado_compra' => 'nullable|in:pendiente,pagado,cancelado',
            ]);

            $compra->estado_compra = $request->estado_compra;
            $compra->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al cambiar el estado de la compra: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}
