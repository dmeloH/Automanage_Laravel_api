<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\GetAuthenticatedUserUseCase;
use App\Application\UseCases\LoginUserUseCase;
use App\Application\UseCases\LogoutUserUseCase;
use App\Application\UseCases\RefreshTokenUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Application\UseCases\RegisterUserUseCase;
use App\Infrastructure\Repositories\EloquentUsuarioRepository;
use App\Infrastructure\Auth\JWTService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private RegisterUserUseCase $registerUseCase;

    public function __construct()
    {
        $repo = new EloquentUsuarioRepository();
        $jwt = new JWTService();
        $this->registerUseCase = new RegisterUserUseCase($repo, $jwt);
    }

    public function registrar(Request $request): JsonResponse
    {
        $data = $request->only([
            'nombre',
            'email',
            'password',
            'telefono',
            'direccion',
            'role',
            'username'
        ]);

        try {
            $result = $this->registerUseCase->execute($data);
            return response()->json([
                'success' => true,
                'token' => $result['token'],
                'user' => $result['user']
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $useCase = new LoginUserUseCase(new EloquentUsuarioRepository());
        $result = $useCase->execute($request->email, $request->password);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $result['user'],
            'token' => $result['token'],
        ]);
    }

    public function logout(): JsonResponse
    {
        $useCase = new LogoutUserUseCase(new EloquentUsuarioRepository());
        $useCase->execute();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada con éxito',
        ]);
    }


    public function refresh(): JsonResponse
    {
        try {
            $useCase = new RefreshTokenUseCase(new JWTService());
            $token = $useCase->execute();

            return response()->json([
                'success' => true,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function user(): JsonResponse
    {
        try {
            $useCase = new GetAuthenticatedUserUseCase(new JWTService());
            $usuario = $useCase->execute();

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $usuario->getId(),
                    'nombre' => $usuario->getNombre(),
                    'email' => $usuario->getEmail(),
                    'username' => $usuario->getUsername(),
                    'role' => $usuario->getRole(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
}
