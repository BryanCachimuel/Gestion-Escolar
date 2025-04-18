<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categorias;
use App\Http\Controllers\Proveedores;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DetalleVentas;
use App\Http\Controllers\Productos;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Ventas;
use Illuminate\Support\Facades\Route;

// crear un usuario administrador, solo usar una vez
//Route::get('/crear-administrador', [AuthController::class, 'crearAdministrador']);


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

// middleware auth autentifica a un grupo de rutas y las protege para que no se puedan ingresar si un usuario no esta logeado
Route::middleware("auth")->group(function(){
    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


// Prefijo para todas las rutas que tengan que ver con ventas
Route::prefix('ventas')->middleware("auth")->group(function(){
    Route::get('/nueva-venta', [Ventas::class, 'index'])->name('ventas-nueva');
});

// Prefijo para todas las rutas que tengan que ver con detalle de ventas
Route::prefix('detalle')->middleware("auth")->group(function(){
    Route::get('/detalle-venta', [DetalleVentas::class, 'index'])->name('detalle-venta');
});

// Prefijo para todas las rutas que tengan que ver con categorias
Route::prefix('categorias')->middleware("auth")->group(function(){
    Route::get('/', [Categorias::class, 'index'])->name('categorias');
    Route::get('/create', [Categorias::class, 'create'])->name('categorias.create');
    Route::post('/store', [Categorias::class, 'store'])->name('categorias.store');
    Route::get('/show/{id}', [Categorias::class, 'show'])->name('categorias.show');
    Route::get('/edit/{id}', [Categorias::class, 'edit'])->name('categorias.edit');
    Route::put('/update/{id}', [Categorias::class, 'update'])->name('categorias.update');
    Route::delete('/destroy/{id}', [Categorias::class, 'destroy'])->name('categorias.destroy');
});

// Prefijo para todas las rutas que tengan que ver con productos
Route::prefix('productos')->middleware("auth")->group(function(){
    Route::get('/', [Productos::class, 'index'])->name('productos');
    Route::get('/create', [Productos::class, 'create'])->name('productos.create');
    Route::post('/store', [Productos::class, 'store'])->name('productos.store');
    Route::get('/edit/{id}', [Productos::class, 'edit'])->name('productos.edit');
    Route::put('/update/{id}', [Productos::class, 'update'])->name('productos.update');
});

// Prefijo para todas las rutas que tengan que ver con clientes
Route::prefix('proveedores')->middleware("auth")->group(function(){
    Route::get('/', [Proveedores::class, 'index'])->name('proveedores');
    Route::get('/create', [Proveedores::class, 'create'])->name('proveedores.create');
    Route::post('/store', [Proveedores::class, 'store'])->name('proveedores.store');
    Route::get('/edit/{id}', [Proveedores::class, 'edit'])->name('proveedores.edit');
    Route::put('/update/{id}', [Proveedores::class, 'update'])->name('proveedores.update');
    Route::get('/show/{id}', [Proveedores::class, 'show'])->name('proveedores.show');
    Route::delete('/destroy/{id}', [Proveedores::class, 'destroy'])->name('proveedores.destroy');
});

// Prefijo para todas las rutas que tengan que ver con usuarios
Route::prefix('usuarios')->middleware("auth")->group(function(){
    Route::get('/', [Usuarios::class, 'index'])->name('usuarios');
    Route::get('/create', [Usuarios::class, 'create'])->name('usuarios.create');
    Route::post('/store', [Usuarios::class, 'store'])->name('usuarios.store');
    Route::get('/edit/{id}', [Usuarios::class, 'edit'])->name('usuarios.edit');
    Route::put('/update/{id}', [Usuarios::class, 'update'])->name('usuarios.update');
    Route::get('/tbody', [Usuarios::class, 'tbody'])->name('usuarios.tbody');
    Route::get('/cambiar-estado/{id}/{estado}', [Usuarios::class, 'estado'])->name('usuarios.estado');
    Route::get('/cambiar-password/{id}/{estado}', [Usuarios::class, 'cambio_password'])->name('usuarios.password');
});


