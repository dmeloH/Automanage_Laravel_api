<?php

namespace App\Application\UseCases;

use App\Infrastructure\Auth\JWTService;
use App\Domain\Models\Usuario;

class GetAuthenticatedUserUseCase
{
    private JWTService $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function execute(): Usuario
    {
        $usuario = $this->jwtService->getAuthenticatedUser();
        if (!$usuario) {
            throw new \Exception("No se pudo obtener el usuario autenticado", 401);
        }

        return $usuario;
    }
}
