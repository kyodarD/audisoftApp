<?php

use App\Http\Controllers\CompraController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\EmpleadoController; // Agregamos la importación del controlador de empleados

Route::get('/', function () { return view('welcome'); })->name('welcome');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function() {
    // PANEL DE CONTROL
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // SLIDERS
    Route::resource('sliders', SliderController::class);
    Route::get('cambioestadoslider', [SliderController::class, 'cambioestadoslider'])->name('cambioestadoslider');

    // ACCESO (ROLES Y USUARIOS)
    Route::resource('roles', RolController::class);
    Route::resource('users', UsuarioController::class);
    Route::get('cambioestadouser', [UsuarioController::class, 'cambioestadouser'])->name('cambioestadouser');

    // GESTIÓN DE PERMISOS
    Route::resource('permissions', PermissionController::class);

    // ASIGNACIÓN DE ROLES A USUARIOS (Si `editRoles()` y `updateRoles()` existen en `UsuarioController.php`)
    if (method_exists(UsuarioController::class, 'editRoles') && method_exists(UsuarioController::class, 'updateRoles')) {
        Route::get('users/{user}/roles', [UsuarioController::class, 'editRoles'])->name('users.editRoles');
        Route::post('users/{user}/roles', [UsuarioController::class, 'updateRoles'])->name('users.updateRoles');
    }

    // CATEGORÍAS
    Route::resource('categorias', CategoriaController::class);
    Route::get('cambioestadocategoria', [CategoriaController::class, 'cambioestadocategoria'])->name('cambioestadocategoria');

    // PRODUCTOS
    Route::resource('productos', ProductoController::class);
    Route::get('cambioestadoproducto', [ProductoController::class, 'cambioestadoproducto'])->name('cambioestadoproducto');
    Route::get('productos/info/{id}', [ProductoController::class, 'getInfo'])->name('productos.info');

    // PROVEEDORES
  // Rutas RESTful de proveedores con nombre de parámetro corregido
    Route::resource('proveedores', ProveedorController::class)->parameters([
        'proveedores' => 'proveedor'
    ]);


    Route::get('cambioestadoproveedor', [ProveedorController::class, 'cambioestadoproveedor'])->name('cambioestadoproveedor');

    // CLIENTES
    Route::resource('clientes', ClienteController::class); 
    Route::get('cambioestadocliente', [ClienteController::class, 'cambioestadocliente'])->name('cambioestadocliente'); 

    // VENTAS
    Route::resource('ventas', VentaController::class); 
    Route::get('cambioestadoventa', [VentaController::class, 'cambioestadoventa'])->name('cambioestadoventa'); 

    // COMPRAS
    Route::resource('compras', CompraController::class); 
    Route::get('cambioestadocompra', [CompraController::class, 'cambioestadocompra'])->name('cambioestadocompra'); 

    // EMPLEADOS (Rutas para empleados)
    Route::resource('empleados', EmpleadoController::class); // Ruta para gestionar empleados
    Route::get('cambioestadoempleado', [EmpleadoController::class, 'cambioestadoempleado'])->name('cambioestadoempleado'); // Ruta para cambiar el estado del empleado
});
