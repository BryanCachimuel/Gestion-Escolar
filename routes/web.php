<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categorias;
use App\Http\Controllers\Compras;
use App\Http\Controllers\Proveedores;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DetalleVentas;
use App\Http\Controllers\Inicio;
use App\Http\Controllers\Productos;
use App\Http\Controllers\ReportesProductos;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Ventas;
use Illuminate\Support\Facades\Route;

// crear un usuario administrador, solo usar una vez
//Route::get('/crear-administrador', [AuthController::class, 'crearAdministrador']);

Route::get('/', [Inicio::class, 'index'])->name('inicio');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');

// middleware auth autentifica a un grupo de rutas y las protege para que no se puedan ingresar si un usuario no esta logeado
Route::middleware("auth")->group(function(){
    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


// Prefijo para todas las rutas que tengan que ver con ventas
Route::prefix('ventas')->middleware("auth")->group(function(){
    Route::get('/nueva-venta', [Ventas::class, 'index'])->name('ventas-nueva');
    Route::get('/agregar-carrito/{id_producto}', [Ventas::class, 'agregar_carrito'])->name('ventas.agregar.carrito');
    Route::get('/borrar-carrito', [Ventas::class, 'borrar_carrito'])->name('ventas.borrar.carrito');
    Route::get('/quitar-carrito/{id_producto}', [Ventas::class, 'quitar_carrito'])->name('ventas.quitar.carrito');
    Route::post('/vender', [Ventas::class, 'vender'])->name('ventas.vender');
});

// Prefijo para todas las rutas que tengan que ver con detalle de ventas
Route::prefix('detalle')->middleware("auth")->group(function(){
    Route::get('/detalle-venta', [DetalleVentas::class, 'index'])->name('detalle-venta');
    Route::get('/vista-detalle/{id_venta}', [DetalleVentas::class, 'vista_detalle'])->name('detalle.vista.detalle');
    Route::delete('/revocar/{id_venta}', [DetalleVentas::class, 'revocar'])->name('detalle.revocar');
    Route::get('/ticket/{id_venta}', [DetalleVentas::class, 'generarTicket'])->name('detalle.ticket');
});

// Prefijo para todas las rutas que tengan que ver con categorias
Route::prefix('categorias')->middleware("auth", "Checkrol:admin")->group(function(){
    Route::get('/', [Categorias::class, 'index'])->name('categorias');
    Route::get('/create', [Categorias::class, 'create'])->name('categorias.create');
    Route::post('/store', [Categorias::class, 'store'])->name('categorias.store');
    Route::get('/show/{id}', [Categorias::class, 'show'])->name('categorias.show');
    Route::get('/edit/{id}', [Categorias::class, 'edit'])->name('categorias.edit');
    Route::put('/update/{id}', [Categorias::class, 'update'])->name('categorias.update');
    Route::delete('/destroy/{id}', [Categorias::class, 'destroy'])->name('categorias.destroy');
});

// Prefijo para todas las rutas que tengan que ver con productos
Route::prefix('productos')->middleware("auth", "Checkrol:admin")->group(function(){
    Route::get('/', [Productos::class, 'index'])->name('productos');
    Route::get('/create', [Productos::class, 'create'])->name('productos.create');
    Route::post('/store', [Productos::class, 'store'])->name('productos.store');
    Route::get('/edit/{id}', [Productos::class, 'edit'])->name('productos.edit');
    Route::put('/update/{id}', [Productos::class, 'update'])->name('productos.update');

    Route::get('/show-image/{id}', [Productos::class, 'show_image'])->name('productos.show.image');
    Route::put('/update-image/{id}', [Productos::class, 'update_image'])->name('productos.update.image');
    
    Route::get('/show/{id}', [Productos::class, 'show'])->name('productos.show');
    Route::delete('/destroy/{id}', [Productos::class, 'destroy'])->name('productos.destroy');
    Route::get('/cambiar-estado/{id}/{estado}', [Productos::class, 'estado'])->name('productos.estado');
});

// Prefijo para todas las rutas que tengan que ver con reportes
Route::prefix('reportes_productos')->middleware("auth", "Checkrol:admin")->group(function(){
    Route::get('/', [ReportesProductos::class, 'index'])->name('reportes_productos');
    Route::get('/falta-stock', [ReportesProductos::class, 'falta_stock'])->name('reportes_productos.falta_stock');
});

// Prefijo para todas las rutas que tengan que ver con clientes
Route::prefix('proveedores')->middleware("auth", "Checkrol:admin")->group(function(){
    Route::get('/', [Proveedores::class, 'index'])->name('proveedores');
    Route::get('/create', [Proveedores::class, 'create'])->name('proveedores.create');
    Route::post('/store', [Proveedores::class, 'store'])->name('proveedores.store');
    Route::get('/edit/{id}', [Proveedores::class, 'edit'])->name('proveedores.edit');
    Route::put('/update/{id}', [Proveedores::class, 'update'])->name('proveedores.update');
    Route::get('/show/{id}', [Proveedores::class, 'show'])->name('proveedores.show');
    Route::delete('/destroy/{id}', [Proveedores::class, 'destroy'])->name('proveedores.destroy');
});

// Prefijo para todas las rutas que tengan que ver con usuarios
Route::prefix('usuarios')->middleware("auth", "Checkrol:admin")->group(function(){
    Route::get('/', [Usuarios::class, 'index'])->name('usuarios');
    Route::get('/create', [Usuarios::class, 'create'])->name('usuarios.create');
    Route::post('/store', [Usuarios::class, 'store'])->name('usuarios.store');
    Route::get('/edit/{id}', [Usuarios::class, 'edit'])->name('usuarios.edit');
    Route::put('/update/{id}', [Usuarios::class, 'update'])->name('usuarios.update');
    Route::get('/show/{id}', [Usuarios::class, 'show'])->name('usuarios.show');
    Route::delete('/destroy/{id}', [Usuarios::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/tbody', [Usuarios::class, 'tbody'])->name('usuarios.tbody');
    Route::get('/cambiar-estado/{id}/{estado}', [Usuarios::class, 'estado'])->name('usuarios.estado');
    Route::get('/cambiar-password/{id}/{estado}', [Usuarios::class, 'cambio_password'])->name('usuarios.password');
});

// Prefijo para todas las rutas que tengan que ver con las compras
Route::prefix('compras')->middleware("auth", "Checkrol:admin")->group(function(){
    Route::get('/', [Compras::class, 'index'])->name('compras');
    Route::get('/create/{producto_id}', [Compras::class, 'create'])->name('compras.create');
    Route::post('/store', [Compras::class, 'store'])->name('compras.store');
    Route::get('/edit/{id}', [Compras::class, 'edit'])->name('compras.edit');
    Route::put('/update/{id}', [Compras::class, 'update'])->name('compras.update');
    Route::get('/show/{id}', [Compras::class, 'show'])->name('compras.show');
    Route::delete('/destroy/{id}', [Compras::class, 'destroy'])->name('compras.destroy');
});


