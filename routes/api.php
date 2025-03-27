<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClienteController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/usuarios/{id}', [AuthController::class, 'showUser']);
Route::get('/usuarios', [AuthController::class, 'index']); 
Route::get('/clientes/{id}/ventas', [ClienteController::class, 'ventas']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes/{id}', [ClienteController::class, 'show']);
Route::get('/clientes', [ClienteController::class, 'index']); 
Route::get('/productos', [ProductoController::class, 'index']);

Route::get('/ventas', [VentaController::class, 'index']);
Route::get('/ventas/{id}', [VentaController::class, 'show']);
Route::post('/ventas', [VentaController::class, 'store']);
