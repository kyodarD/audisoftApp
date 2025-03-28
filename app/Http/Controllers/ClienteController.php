<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Traits\HasPermissionMiddleware;

class ClienteController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('clientes');
    }

    // Muestra todos los clientes
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    // Muestra el formulario para crear un cliente
    public function create()
    {
        return view('clientes.create');
    }

    // Almacena un nuevo cliente en la base de datos
    public function store(ClienteRequest $request)
    {
        $validated = $request->validated(); // Valida los datos con el ClienteRequest

        try {
            // Asignar el ID del usuario autenticado al campo 'registradopor'
            $validated['registradopor'] = auth()->id();

            // Crear el nuevo cliente con los datos validados
            Cliente::create($validated);

            return redirect()->route('clientes.index')->with('successMsg', 'El cliente se registró exitosamente');
        } catch (Exception $e) {
            Log::error('Error al guardar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('Ocurrió un error al guardar el cliente. Inténtelo nuevamente.');
        }
    }

    // Muestra el formulario para editar un cliente existente
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // Actualiza un cliente existente
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $validated = $request->validated(); // Validación de los datos con el ClienteRequest

        try {
            // Actualizar los datos del cliente
            $cliente->update($validated);

            return redirect()->route('clientes.index')->with('successMsg', 'El cliente se actualizó exitosamente');
        } catch (Exception $e) {
            Log::error('Error al actualizar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('Ocurrió un error al actualizar el cliente. Inténtelo nuevamente.');
        }
    }

    // Elimina un cliente
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return redirect()->route('clientes.index')->with('successMsg', 'El cliente se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('El cliente tiene información relacionada. Comuníquese con el Administrador.');
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('Ocurrió un error inesperado. Comuníquese con el Administrador.');
        }
    }

    // Cambia el estado de un cliente
    public function cambioEstadoCliente(Request $request)
    {
        try {
            $cliente = Cliente::findOrFail($request->id);
            $cliente->estado = $request->estado;
            $cliente->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al cambiar el estado del cliente: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}
