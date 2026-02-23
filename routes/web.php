<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SucursalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoVarianteController;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\OrdenVentaController;
use App\Http\Controllers\Admin\OrdenVentaDetalleController;
use App\Http\Controllers\Admin\OrdenVentaMermaController;
use App\Http\Controllers\Admin\OrdenVentaGastosController;
use App\Http\Controllers\Admin\CorteController;
use App\Http\Controllers\Admin\RemisionController;
use App\Http\Controllers\Admin\MovimientoInventarioController;
use App\Livewire\OrdenVentaGastos;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|supervisor|ventas'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // CRUD base
        Route::resource('sucursales', SucursalController::class);
        Route::resource('usuarios', UserController::class);
        Route::resource('categorias', CategoriaController::class);

        Route::resource('productos', ProductoController::class)
            ->except(['show']);

        Route::resource('productos.variantes', ProductoVarianteController::class)
            ->except(['show']);

        // INVENTARIO POR SUCURSAL
        Route::get(
            'sucursales/{sucursal}/inventario',
            [InventarioController::class, 'index']
        )->name('sucursales.inventario.index');

        Route::get(
            'sucursales/{sucursal}/inventario/editar',
            [InventarioController::class, 'edit']
        )->name('sucursales.inventario.edit');

        Route::post(
            'sucursales/{sucursal}/inventario',
            [InventarioController::class, 'update']
        )->name('sucursales.inventario.update');

        Route::get(
            'sucursales/{sucursal}/inventario/movimientos',
            [InventarioController::class, 'movimientos']
        )->name('sucursales.inventario.movimientos');

        Route::resource('movimientos', MovimientoInventarioController::class);

        Route::resource('ordenes', OrdenVentaController::class)
        ->parameters(['ordenes' => 'orden'])
        ->except(['destroy']);


        Route::patch(
            'ordenes/{orden}/estado',
            [OrdenVentaController::class, 'cambiarEstado']
        )->name('ordenes.estado');

        Route::post(
            'ordenes/{orden}/detalle',
            [OrdenVentaDetalleController::class, 'store']
        )->name('ordenes.detalle.store');

        Route::get(
            'ordenes/{orden}/mermas',
            [OrdenVentaMermaController::class, 'index']
        )->name('ordenes.mermas');

        Route::get(
            'ordenes/{orden}/mermas',
            [OrdenVentaMermaController::class, 'index']
        )->name('ordenes.mermas.index');

        Route::get(
        'ordenes/{orden}/gastos',
            [OrdenVentaGastosController::class, 'index']
        )->name('ordenes.gastos.index');

        Route::delete('ordenes/{orden}', 
            [OrdenVentaController::class, 'destroy']
        )->name('ordenes.destroy');

        Route::patch('ordenes/{orden}/estado', 
            [OrdenVentaController::class, 'cambiarEstado']
        )->name('ordenes.cambiarEstado');

        Route::get(
            'ordenes/{orden}/pdf',
            [OrdenVentaController::class, 'pdf']
        )->name('ordenes.pdf');


        Route::resource('cortes', CorteController::class)
        ->only(['index', 'create', 'store', 'show']);

        Route::resource('remisiones', RemisionController::class)
        ->parameters([
            'remisiones' => 'remision'
        ]);

          Route::patch('remisiones/{remision}/estado', 
            [RemisionController::class, 'cambiarEstado']
        )->name('remisiones.cambiarEstado');

    

    });

        
        
