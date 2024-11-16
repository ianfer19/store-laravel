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
    // Ruta para editar el perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::middleware('auth')->get('/dashboard', [ProductoController::class, 'comprar'])->name('dashboard');

    // Rutas de mensajes
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/{userId}', [MensajeController::class, 'obtenerMensajesEntre'])->name('mensajes.conversacion');
    Route::post('/mensajes/{userId}', [MensajeController::class, 'enviarMensaje'])->name('mensajes.enviar');
    Route::get('/mensajes/conversacion/{userId}', [MensajeController::class, 'conversacion'])->name('mensajes.conversacion');

    // Rutas de productos y ventas
    Route::get('productos/comprar', [ProductoController::class, 'comprar'])->name('productos.comprar');
    Route::resource('ventas', VentaController::class);
// Asegúrate de que la ruta esté correctamente definida
Route::post('detalleVenta', [DetalleVentaController::class, 'storeDetalleVenta']);

    Route::resource('productos', ProductoController::class);
    Route::resource('users', UserController::class);
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
