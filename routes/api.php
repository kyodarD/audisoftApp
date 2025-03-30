<?php
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClienteController;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/usuarios/{id}', [AuthController::class, 'showUser']);
Route::get('/usuarios', [AuthController::class, 'index']); 
Route::delete('usuarios/{id}', [AuthController::class, 'destroy']);


// Rutas de clientes
Route::get('clientes', [ClienteController::class, 'index']);
Route::get('clientes/{cliente}', [ClienteController::class, 'show']);
Route::post('clientes', [ClienteController::class, 'store']);
Route::put('clientes/{cliente}', [ClienteController::class, 'update']);
Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy']);

// Rutas de productos
Route::get('productos', [ProductoController::class, 'index']);
Route::get('productos/{producto}', [ProductoController::class, 'show']);
Route::post('productos', [ProductoController::class, 'store']);
Route::put('productos/{producto}', [ProductoController::class, 'update']);
Route::delete('productos/{producto}', [ProductoController::class, 'destroy']);

// Rutas de ventas
Route::get('ventas', [VentaController::class, 'index']);
Route::get('ventas/{venta}', [VentaController::class, 'show']);
Route::post('ventas', [VentaController::class, 'store']);
Route::put('ventas/{venta}', [VentaController::class, 'update']);
Route::delete('ventas/{venta}', [VentaController::class, 'destroy']);
// Rutas para obtener imágenes de productos
Route::get('productos/{producto}/imagen', [ProductoController::class, 'mostrarImagen'])->name('producto.imagen');

