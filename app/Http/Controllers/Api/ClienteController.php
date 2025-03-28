<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Método para crear un cliente (store)
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'cedula'    => 'required|string|max:20|unique:clientes,cedula',
            'direccion' => 'required|string|max:255',
            'telefono'  => 'required|string|max:20',
            'email'     => 'required|email|unique:clientes,email',
            'registradopor' => 'required|integer|exists:users,id'
        ]);
    
        $cliente = Cliente::create([
            'nombre'        => $request->nombre,
            'cedula'        => $request->cedula,
            'direccion'     => $request->direccion,
            'telefono'      => $request->telefono,
            'email'         => $request->email,
            'estado'        => 1,
            'registradopor' => $request->registradopor
        ]);
    
        return response()->json([
            'mensaje' => 'Cliente registrado correctamente',
            'cliente' => $cliente
        ], 201);
    }

    // Mostrar detalles de un cliente por ID (show)
    public function show($id)
    {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }
        
        return response()->json($cliente);
    }

    // Listar todos los clientes (index)
    public function index()
    {
        $clientes = Cliente::all();
        
        return response()->json([
            'mensaje' => 'Lista de clientes',
            'clientes' => $clientes
        ]);
    }

    // Ver ventas de un cliente por ID (ventas)
    public function ventas($id)
    {
        $cliente = Cliente::with('ventas.detalles.producto')->find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        return response()->json([
            'cliente' => $cliente->nombre,
            'ventas' => $cliente->ventas
        ]);
    }

    // Actualizar un cliente (update)
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        // Validaciones de los datos
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'cedula'    => 'required|string|max:20|unique:clientes,cedula,' . $id,
            'direccion' => 'required|string|max:255',
            'telefono'  => 'required|string|max:20',
            'email'     => 'required|email|unique:clientes,email,' . $id
        ]);

        // Actualización de los datos del cliente
        $cliente->update([
            'nombre'        => $request->nombre,
            'cedula'        => $request->cedula,
            'direccion'     => $request->direccion,
            'telefono'      => $request->telefono,
            'email'         => $request->email,
            // Puedes agregar más campos aquí si es necesario
        ]);

        return response()->json([
            'mensaje' => 'Cliente actualizado correctamente',
            'cliente' => $cliente
        ]);
    }

    // Eliminar un cliente (destroy)
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['mensaje' => 'Cliente eliminado correctamente']);
    }
}
