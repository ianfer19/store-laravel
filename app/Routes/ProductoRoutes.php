<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

        Route::prefix('productos')->group(function() {
            Route::get('/', [ProductoController::class, 'index']);
            Route::post('/', [ProductoController::class, 'store']);
            Route::get('{id}', [ProductoController::class, 'show']);
            Route::put('{id}', [ProductoController::class, 'update']);
            Route::delete('{id}', [ProductoController::class, 'destroy']);
        });