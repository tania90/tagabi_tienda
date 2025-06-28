<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecompensaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ExportacionController;

Route::get('/', function () {
    return view('dashboard');
});

// Rutas protegidas por login
Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('ventas', VentaController::class)->middleware(['auth']);

//Route::get('/dashboard', function () {
 //   return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::get('usuarios/crear', [UsuarioController::class, 'create'])->name('admin.usuarios.create');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('admin.usuarios.store');
    Route::get('usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
    Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');
});

Route::get('password/change', [App\Http\Controllers\Auth\PasswordController::class, 'edit'])->name('password.change');
Route::post('password/update', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');


Route::resource('productos', \App\Http\Controllers\ProductoController::class)->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('clientes/{cliente}/historial', [App\Http\Controllers\ClienteController::class, 'historial'])->name('clientes.historial');
Route::get('clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');

Route::get('/recompensas', [RecompensaController::class, 'index'])->name('recompensas.index');
Route::post('/recompensas/{cliente}/canjear', [RecompensaController::class, 'canjear'])->name('recompensas.canjear');
Route::post('recompensas/canjear/{cliente}', [RecompensaController::class, 'canjear'])->name('recompensas.canjear');

Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');

Route::resource('ventas', VentaController::class);

Route::resource('categorias', \App\Http\Controllers\CategoriaController::class);

Route::get('/exportar-productos', [ExportacionController::class, 'exportarProductos'])->name('exportar.productos');
Route::get('/exportaciones', [ExportacionController::class, 'index'])->name('exportaciones.index');
Route::get('/exportaciones/productos', [ExportacionController::class, 'exportarProductos'])->name('exportaciones.productos');
Route::get('/exportaciones/clientes', [ExportacionController::class, 'exportarClientes'])->name('exportaciones.clientes');
Route::get('/exportaciones/recompensas', [ExportacionController::class, 'exportarRecompensas'])->name('exportaciones.recompensas');

Route::get('/profile', function () {
    return 'Perfil en construcción';
})->name('profile.edit');


require __DIR__.'/auth.php';
