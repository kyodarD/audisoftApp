<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
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

                public function show($id)
                {
                    $cliente = Cliente::find($id);
                
                    if (!$cliente) {
                        return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
                    }
                
                    return response()->json($cliente);
                }
                public function index()
            {
                $clientes = Cliente::all();

                return response()->json([
                    'mensaje' => 'Lista de clientes',
                    'clientes' => $clientes
                ]);
            }



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

}    