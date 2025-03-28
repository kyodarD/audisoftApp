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

// Rutas de clientes
Route::resource('clientes', ClienteController::class);

// Rutas de productos
Route::resource('productos', ProductoController::class);

// Rutas de ventas
Route::resource('ventas', VentaController::class);
