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

// --- CITAS ---
// Listar y ver citas: admin y user
Route::middleware(['api', 'auth.role:admin,user'])->group(function () {
    Route::get('citas', [CitaController::class, 'index']);
    Route::get('citas/{cita}', [CitaController::class, 'show']);
});
// Crear, actualizar, eliminar citas: solo admin
Route::middleware(['api', 'auth.role:admin'])->group(function () {
    Route::post('citas', [CitaController::class, 'store']);
    Route::put('citas/{cita}', [CitaController::class, 'update']);
    Route::delete('citas/{cita}', [CitaController::class, 'destroy']);
});

// --- REGISTROS ---
// Listar y ver registros: admin y user
Route::middleware(['api', 'auth.role:admin,user'])->group(function () {
    Route::get('registros', [RegistroManteController::class, 'index']);
    Route::get('registros/{registro}', [RegistroManteController::class, 'show']);
});
// Crear, actualizar, eliminar registros: solo admin
Route::middleware(['api', 'auth.role:admin'])->group(function () {
    Route::post('registros', [RegistroManteController::class, 'store']);
    Route::put('registros/{registro}', [RegistroManteController::class, 'update']);
    Route::delete('registros/{registro}', [RegistroManteController::class, 'destroy']);
});

// --- VEHICULOS ---
// Listar y ver vehículos: admin y user
Route::middleware(['api', 'auth.role:admin,user'])->group(function () {
    Route::get('vehiculos', [VehiculoController::class, 'index']);
    Route::get('vehiculos/{vehiculo}', [VehiculoController::class, 'show']);
});
// Crear, actualizar, eliminar vehículos: solo admin
Route::middleware(['api', 'auth.role:admin'])->group(function () {
    Route::post('vehiculos', [VehiculoController::class, 'store']);
    Route::put('vehiculos/{vehiculo}', [VehiculoController::class, 'update']);
    Route::delete('vehiculos/{vehiculo}', [VehiculoController::class, 'destroy']);
});

// --- USUARIOS (solo admin) ---
Route::middleware(['api', 'auth.role:admin'])->group(function () {
    Route::resource('data', UserController::class);
});
