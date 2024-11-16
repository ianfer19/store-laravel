<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;

Route::get('venta', [VentaController::class, 'index']);
Route::get('venta/{id}', [VentaController::class, 'show']);
Route::post('venta', [VentaController::class, 'store']);
Route::put('venta/{id}', [VentaController::class, 'update']);
Route::delete('venta/{id}', [VentaController::class, 'destroy']);
