<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validaciones personalizadas
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
    
        // Si falla la validación, devuelve respuesta JSON
        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }
    
        // Crear el usuario
        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'remember_token'    => Str::random(60),
            'estado'            => 1,
            'role_id'           => 2,            
            'email_verified_at' => now(),        
        ]);
    
        return response()->json([
            'mensaje' => 'Usuario registrado correctamente',
            'usuario' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        // Validar campos
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        // Buscar al usuario por email
        $user = User::where('email', $request->email)->first();

        // Validar existencia y contraseña
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'mensaje' => 'Credenciales inválidas'
            ], 401);
        }

        // Retornar usuario autenticado
        return response()->json([
            'mensaje' => 'Inicio de sesión exitoso',
            'usuario' => $user
        ]);
    }

    // Listar todos los usuarios (index)
    public function index()
    {
        // Listar todos los usuarios, con paginación
        $usuarios = User::paginate(10);  // Puedes ajustar el número de usuarios por página
        return response()->json($usuarios);
    }

    // Ver usuario por ID (show)
    public function showUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user);
    }

    // Actualizar usuario (update)
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        // Validar los datos si es necesario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            // Añadir validaciones adicionales si es necesario
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        // Actualizar usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Puedes actualizar más campos si lo deseas
        ]);

        return response()->json([
            'mensaje' => 'Usuario actualizado correctamente',
            'usuario' => $user
        ]);
    }

    // Eliminar usuario (destroy)
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente']);
    }
}
