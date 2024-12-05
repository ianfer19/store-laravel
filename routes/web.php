
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    // Rutas relacionadas al perfil de usuario
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    // Ruta para el dashboard
    Route::get('/dashboard', [ProductoController::class, 'comprar'])->name('dashboard');

    // Rutas de mensajes
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/{userId}', [MensajeController::class, 'obtenerMensajesEntre'])->name('mensajes.conversacion');
    Route::post('/mensajes/{userId}', [MensajeController::class, 'enviarMensaje'])->name('mensajes.enviar');
    Route::get('/mensajes/conversacion/{userId}', [MensajeController::class, 'conversacion'])->name('mensajes.conversacion');

    // Rutas de productos y ventas
    Route::get('productos/comprar', [ProductoController::class, 'comprar'])->name('productos.comprar');
    Route::get('/productos/mis-productos', [ProductoController::class, 'misProductos'])->name('productos.mis_productos');
    Route::resource('productos', ProductoController::class);

    Route::resource('ventas', VentaController::class);
    Route::post('detalleVenta', [DetalleVentaController::class, 'storeDetalleVenta']);

    Route::resource('users', UserController::class);
    Route::get('/dashboard', [VentaController::class, 'dashboard'])->name('dashboard')->middleware('auth');

});

// Rutas de autenticación (solo para usuarios no autenticados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Ruta para logout
Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Capturar todas las rutas no definidas y redirigir a productos/comprar
Route::fallback(function () {
    return redirect()->route('productos.comprar');
});
