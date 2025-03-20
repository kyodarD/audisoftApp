<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta; // Importación del modelo Venta
use App\Models\Cliente; // Importación del modelo Cliente
use App\Http\Requests\VentaRequest; // Importación del request de validación
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{
    // Muestra todas las ventas
    public function index()
    {
        $ventas = Venta::all(); // Obtener todas las ventas
        $clientes = Cliente::all();
        $productos = Producto::all();

        // Pasamos tanto las ventas como los clientes a la vista
        return view('ventas.index', compact('ventas', 'clientes', 'productos'));
    }

    // Muestra el formulario para crear una nueva venta
    public function create()
    {
        // Obtener todos los clientes y productos para el formulario de creación
        $clientes = Cliente::all();
        $productos = Producto::all();

        // Pasamos los clientes y productos a la vista de creación
        return view('ventas.create', compact('clientes', 'productos'));
    }

    // Almacena una nueva venta en la base de datos
    public function store(VentaRequest $request)
    {
        // Validación de los datos con el VentaRequest
        $validated = $request->validated();

        try {
            // Asignar el usuario autenticado al campo 'registradopor'
            $validated['registradopor'] = auth()->user()->id; // ID del usuario autenticado

            // Crear la nueva venta con los datos validados
            Venta::create($validated);

            return redirect()->route('ventas.index')->with('successMsg', 'La venta se registró exitosamente');
        } catch (Exception $e) {
            Log::error('Error al guardar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.index')->withErrors('Ocurrió un error al guardar la venta. Inténtelo nuevamente.');
        }
    }

    // Muestra el formulario para editar una venta existente
    public function edit(Venta $venta)
    {
        // Obtener todos los clientes y productos para el formulario de edición
        $clientes = Cliente::all();
        $productos = Producto::all();

        // Pasar la venta, los clientes y los productos a la vista de edición
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    // Actualiza una venta existente
    public function update(VentaRequest $request, Venta $venta)
    {
        // Validación de los datos con el VentaRequest
        $validated = $request->validated();

        try {
            // Actualizar los datos de la venta
            $venta->update($validated);
            return redirect()->route('ventas.index')->with('successMsg', 'La venta se actualizó exitosamente');
        } catch (Exception $e) {
            Log::error('Error al actualizar la venta: ' . $e->getMessage());
            return redirect()->route('ventas.index')->withErrors('Ocurrió un error al actualizar la venta. Inténtelo nuevamente.');
        }
    }

    // Elimina una venta
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

    // Muestra los detalles de una venta específica
    public function show($id)
    {
        // Obtén la venta junto con sus detalles de productos (relación con DetallesVenta)
        $venta = Venta::with('detallesventa.producto')->findOrFail($id);

        // Pasar la venta con sus detalles a la vista
        return view('ventas.show', compact('venta'));
    }

    // Cambia el estado de una venta
    public function cambioEstadoVenta(Request $request)
    {
        try {
            $venta = Venta::findOrFail($request->id);

            // Validar el campo estado_venta
            $request->validate([
                'estado_venta' => 'nullable|in:pendiente,pagado',
            ]);

            // Actualizar el estado de la venta
            $venta->estado_venta = $request->estado_venta;
            $venta->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al cambiar el estado de la venta: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}
