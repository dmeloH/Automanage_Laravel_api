<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\RegistroManteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;



/**
 * Rutas de la arquitectura limpia
 * - Registro, login, logout, refresh y obtener usuario autenticado.
 */
//Lista de usuarios
Route::get('usuarioclear', [ApiUserController::class, 'show']);
//Registro de usuario
Route::post('RegistrarClear', [ApiAuthController::class, 'registrar']);
//Login de usuario
Route::post('LoginClear', [ApiAuthController::class, 'login']);
//Logout de usuario
Route::get('LogoutClear', [ApiAuthController::class, 'logout'])->middleware('jwt.auth');
//Refrescar token
Route::get('RefreshClear', [ApiAuthController::class, 'refresh']);
//Obtener usuario autenticado
Route::get('UserClear', [ApiAuthController::class, 'user'])->middleware('jwt.auth');


/**
 * Rutas de autenticación
 * - Registro, login, logout, refresh y obtener usuario autenticado.
 */
Route::middleware('api')->group(function () {
    // Registrar nuevo usuario
    Route::post('/auth/signup', [AuthController::class, 'registrar']);
    // Login de usuario
    Route::post('/auth/login', [AuthController::class, 'login']);
    // Logout (requiere token JWT válido)
    Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
    // Refrescar token JWT
    Route::get('/auth/refresh', [AuthController::class, 'refresh']);
    // Obtener usuario autenticado (requiere token JWT válido)
    Route::get('/auth/user', [AuthController::class, 'user'])->middleware('jwt.auth');
});

/**
 * Rutas para CITAS
 * - GET: admin y user pueden listar y ver citas.
 * - POST, PUT, DELETE: solo admin puede crear, actualizar y eliminar citas.
 */
Route::middleware(['api', 'jwt.auth', 'auth.role:admin,user'])->group(function () {
    // Listar todas las citas
    Route::get('citas', [CitaController::class, 'index']);
    // Ver detalles de una cita específica
    Route::get('citas/{cita}', [CitaController::class, 'show']);
});
Route::middleware(['api', 'jwt.auth', 'auth.role:admin'])->group(function () {
    // Crear nueva cita
    Route::post('citas', [CitaController::class, 'store']);
    // Actualizar cita existente
    Route::put('citas/{cita}', [CitaController::class, 'update']);
    // Eliminar cita
    Route::delete('citas/{cita}', [CitaController::class, 'destroy']);
});

/**
 * Rutas para REGISTROS DE MANTENIMIENTO
 * - GET: admin y user pueden listar y ver registros.
 * - POST, PUT, DELETE: solo admin puede crear, actualizar y eliminar registros.
 */
Route::middleware(['api', 'jwt.auth', 'auth.role:admin,user'])->group(function () {
    // Listar todos los registros de mantenimiento
    Route::get('registros', [RegistroManteController::class, 'index']);
    // Ver detalles de un registro específico
    Route::get('registros/{registro}', [RegistroManteController::class, 'show']);
});
Route::middleware(['api', 'auth.role:admin'])->group(function () {
    // Crear nuevo registro de mantenimiento
    Route::post('registros', [RegistroManteController::class, 'store']);
    // Actualizar registro existente
    Route::put('registros/{registro}', [RegistroManteController::class, 'update']);
    // Eliminar registro
    Route::delete('registros/{registro}', [RegistroManteController::class, 'destroy']);
});

/**
 * Rutas para VEHÍCULOS
 * - GET: admin y user pueden listar y ver vehículos.
 * - POST, PUT, DELETE: solo admin puede crear, actualizar y eliminar vehículos.
 */
Route::middleware(['api', 'jwt.auth', 'auth.role:admin,user'])->group(function () {
    // Listar todos los vehículos
    Route::get('vehiculos', [VehiculoController::class, 'index']);
    // Ver detalles de un vehículo específico
    Route::get('vehiculos/{vehiculo}', [VehiculoController::class, 'show']);
});
Route::middleware(['api', 'auth.role:admin'])->group(function () {
    // Crear nuevo vehículo
    Route::post('vehiculos', [VehiculoController::class, 'store']);
    // Actualizar vehículo existente
    Route::put('vehiculos/{vehiculo}', [VehiculoController::class, 'update']);
    // Eliminar vehículo
    Route::delete('vehiculos/{vehiculo}', [VehiculoController::class, 'destroy']);
});

/**
 * Rutas para USUARIOS
 * - Solo admin puede acceder a la gestión de usuarios.
 */
Route::middleware(['api', 'jwt.auth', 'auth.role:admin'])->group(function () {
    // CRUD completo para usuarios (solo admin)
    Route::resource('data', UserController::class);
});

/**
 * Ruta para autenticación con Google
 * - Recibe un id_token de Google, valida el token, busca o crea el usuario y retorna un JWT.
 */
Route::post('/api/auth/google', function (Request $request) {
    $googleToken = $request->input('id_token');

    // Verificar el token con Google
    $response = Http::get("https://oauth2.googleapis.com/tokeninfo", [
        'id_token' => $googleToken
    ]);

    if ($response->failed()) {
        return response()->json(['error' => 'Token inválido'], 401);
    }

    $googleUser = $response->json();

    // Buscar o crear usuario
    $user = Usuario::updateOrCreate(
        ['email' => $googleUser['email']],
        [
            'name' => $googleUser['name'],
            'google_id' => $googleUser['sub'],
            'avatar' => $googleUser['picture'],
        ]
    );

    // Crear el JWT
    $token = JWTAuth::fromUser($user);

    return response()->json([
        'access_token' => $token,
        'user' => $user,
    ]);
});
