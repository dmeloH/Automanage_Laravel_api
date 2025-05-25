<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\UserUseCase ;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
        public function show(): JsonResponse
    {
        $useCase = new UserUseCase();
        $usuario = $useCase->ejecutar();

        return response()->json([
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail(),
            'username' => $usuario->getUsername(),
            'role' => $usuario->getRole(),
            'esAdmin' => $usuario->esAdministrador()
        ]);
    }
}
