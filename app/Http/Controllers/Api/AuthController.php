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


public function index()
{
    // Listar todos los usuarios, con paginación
    $usuarios = User::paginate(10);  // Puedes ajustar el número de usuarios por página
    return response()->json($usuarios);
}

}
