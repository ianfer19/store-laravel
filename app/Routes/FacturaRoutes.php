<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturaController;

Route::get('factura', [FacturaController::class, 'index']);
Route::get('factura/{id}', [FacturaController::class, 'show']);
Route::post('factura', [FacturaController::class, 'store']);
Route::put('factura/{id}', [FacturaController::class, 'update']);
Route::delete('factura/{id}', [FacturaController::class, 'destroy']);
