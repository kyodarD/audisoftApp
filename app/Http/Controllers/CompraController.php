<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Compra; // Importación del modelo Compra
use App\Models\Cliente; // Importación del modelo Cliente
use App\Http\Requests\CompraRequest; // Importación del request de validación
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    // Muestra todas las compras
    public function index()
    {
        $compras = Compra::with('usuario', 'cliente')->get(); // Obtener todas las compras con usuarios y clientes relacionados
        $clientes = Cliente::all();
        $productos = Producto::all();
        // Pasamos tanto las compras como los clientes y productos a la vista
        return view('compras.index', compact('compras', 'clientes', 'productos'));
    }

    // Muestra el formulario para crear una nueva compra
    public function create()
    {
        // Obtener todos los clientes y productos para el formulario de creación
        $clientes = Cliente::all();
        $productos = Producto::all();
        // Pasamos los clientes y productos a la vista de creación
        return view('compras.create', compact('clientes', 'productos'));
    }

    // Almacena una nueva compra en la base de datos
    public function store(CompraRequest $request)
    {
        // Validación de los datos con el CompraRequest
        $validated = $request->validated();
        try {
            // Asignar el usuario autenticado al campo 'registradopor'
            $validated['registradopor'] = auth()->user()->id; // ID del usuario autenticado
            
            // Crear la nueva compra con los datos validados
            $compra = Compra::create($validated);
            
            // Registrar los productos comprados
            foreach ($validated['productos'] as $producto) {
                $compra->productos()->attach($producto['id'], ['cantidad_producto' => $producto['cantidad']]);
            }
            return redirect()->route('compras.index')->with('successMsg', 'La compra se registró exitosamente');
        } catch (Exception $e) {
            Log::error('Error al guardar la compra: ' . $e->getMessage());
            return redirect()->route('compras.index')->withErrors('Ocurrió un error al guardar la compra. Inténtelo nuevamente.');
        }
    }

    // Muestra el formulario para editar una compra existente
    public function edit(Compra $compra)
    {
        // Obtener todos los clientes y productos para el formulario de edición
        $clientes = Cliente::all();
        $productos = Producto::all();
        // Pasar la compra, los clientes y los productos a la vista de edición
        return view('compras.edit', compact('compra', 'clientes', 'productos'));
    }

    // Actualiza una compra existente
    public function update(CompraRequest $request, Compra $compra)
    {
        // Validación de los datos con el CompraRequest
        $validated = $request->validated();
        try {
            // Actualizar los datos de la compra
            $compra->update($validated);
            
            // Actualizar los productos asociados
            $compra->productos()->detach(); // Desvincular productos actuales
            foreach ($validated['productos'] as $producto) {
                $compra->productos()->attach($producto['id'], ['cantidad_producto' => $producto['cantidad']]);
            }
            return redirect()->route('compras.index')->with('successMsg', 'La compra se actualizó exitosamente');
        } catch (Exception $e) {
            Log::error('Error al actualizar la compra: ' . $e->getMessage());
            return redirect()->route('compras.index')->withErrors('Ocurrió un error al actualizar la compra. Inténtelo nuevamente.');
        }
    }

    // Elimina una compra
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

    // Cambia el estado de una compra (si es necesario)
    public function cambioEstadoCompra(Request $request)
    {
        try {
            $compra = Compra::findOrFail($request->id);
            // Validar el campo estado_compra
            $request->validate([
                'estado_compra' => 'nullable|in:pendiente,pagado', // Ejemplo de estados
            ]);
            // Actualizar el estado de la compra
            $compra->estado = $request->estado_compra; // Cambiar el campo estado
            $compra->save();
            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al cambiar el estado de la compra: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}