<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\RegistroManteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;

Route::middleware('api')->group(function () {
    Route::post('/auth/registrar', [AuthController::class, 'registrar']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
    Route::get('/auth/refresh', [AuthController::class, 'refresh']);
    Route::get('/auth/user', [AuthController::class, 'user'])->middleware('jwt.auth');
});

Route::middleware('api', 'auth.role:user')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['message' => 'usuario']);
    });
});

Route::middleware('api', 'auth.role:admin')->group(function () {
    Route::get('/admin', function (Request $request) {
        return response()->json(['message' => 'admin']);
    });
});


Route::middleware('api')->group(function () {
    Route::resource('data', UserController::class);
    Route::resource('citas', CitaController::class);
    Route::resource('mantenimiento', RegistroManteController::class);
    Route::resource('vehiculos', VehiculoController::class);
});



