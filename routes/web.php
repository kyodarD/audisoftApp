<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación con verificación de correo
Auth::routes(['verify' => true]);

// Ruta personalizada para verificar el correo (esta es la clave)
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');


// Rutas protegidas por autenticación y verificación
Route::middleware(['auth', 'verified'])->group(function () {

    // Rutas para mostrar imágenes privadas
    Route::get('/usuarios/imagen/{filename}', [UsuarioController::class, 'mostrarImagen'])->name('imagen.usuario');
    Route::get('/empleados/imagen/{filename}', [EmpleadoController::class, 'mostrarImagen'])->name('imagen.empleado');
    Route::get('productos/{producto}/imagen', [ProductoController::class, 'mostrarImagen'])->name('imagen.producto');

    // Panel de control
    Route::get('/home', [HomeController::class, 'index'])
        ->middleware('can:ver dashboard')
        ->name('home');

    // Sliders
    Route::resource('sliders', SliderController::class);
    Route::get('cambioestadoslider', [SliderController::class, 'cambioestadoslider'])->name('cambioestadoslider');

    // Usuarios
    Route::resource('users', UsuarioController::class);
    Route::get('cambioestadouser', [UsuarioController::class, 'cambioestadouser'])->name('cambioestadouser');

    // Roles
    Route::resource('roles', RolController::class);

    // Permisos
    Route::resource('permissions', PermissionController::class);

    // Asignación de roles a usuarios
    if (method_exists(UsuarioController::class, 'editRoles') && method_exists(UsuarioController::class, 'updateRoles')) {
        Route::get('users/{user}/roles', [UsuarioController::class, 'editRoles'])->name('users.editRoles');
        Route::post('users/{user}/roles', [UsuarioController::class, 'updateRoles'])->name('users.updateRoles');
    }

    // Categorías
    Route::resource('categorias', CategoriaController::class);
    Route::get('cambioestadocategoria', [CategoriaController::class, 'cambioestadocategoria'])->name('cambioestadocategoria');

    // Productos
    Route::resource('productos', ProductoController::class);
    Route::get('cambioestadoproducto', [ProductoController::class, 'cambioestadoproducto'])->name('cambioestadoproducto');
    Route::get('productos/info/{id}', [ProductoController::class, 'getInfo'])->name('productos.info');

    // Proveedores
    Route::resource('proveedores', ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor']);
    Route::get('cambioestadoproveedor', [ProveedorController::class, 'cambioestadoproveedor'])->name('cambioestadoproveedor');

    // Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('cambioestadocliente', [ClienteController::class, 'cambioestadocliente'])->name('cambioestadocliente');

    // Ventas
    Route::resource('ventas', VentaController::class);
    Route::get('cambioestadoventa', [VentaController::class, 'cambioestadoventa'])->name('cambioestadoventa');

    // Compras
    Route::resource('compras', CompraController::class);
    Route::get('cambioestadocompra', [CompraController::class, 'cambioestadocompra'])->name('cambioestadocompra');

    // Empleados
    Route::resource('empleados', EmpleadoController::class);
    Route::get('cambioestadoempleado', [EmpleadoController::class, 'cambioestadoempleado'])->name('cambioestadoempleado');
});
