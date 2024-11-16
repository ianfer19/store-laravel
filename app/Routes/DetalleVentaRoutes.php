<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetalleVentaController;

Route::get('detalle-venta', [DetalleVentaController::class, 'index']);
Route::get('detalle-venta/{id}', [DetalleVentaController::class, 'show']);
Route::post('detalle-venta', [DetalleVentaController::class, 'store']);
Route::put('detalle-venta/{id}', [DetalleVentaController::class, 'update']);
Route::delete('detalle-venta/{id}', [DetalleVentaController::class, 'destroy']);
