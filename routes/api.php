<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Rutas públicas (sin autenticación)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    // Rutas de autenticación
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/me', [AuthController::class, 'me']);
    });
    
    // Rutas de logs - método POST para obtener datos
    Route::post('/logs', [LogController::class, 'index']);
    Route::post('/logs/{id}', [LogController::class, 'getLogsByUserId']);
    
    // Ruta de usuario básica
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
