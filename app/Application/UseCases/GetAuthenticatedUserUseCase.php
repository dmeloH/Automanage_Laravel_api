<?php

namespace App\Application\UseCases;

use App\Infrastructure\Auth\JWTService;
use App\Domain\Models\Usuario;
use Exception;

/**
 * Caso de uso para obtener el usuario actualmente autenticado a partir del token JWT.
 */
class GetAuthenticatedUserUseCase
{
    /**
     * Servicio JWT utilizado para manejar la autenticación.
     *
     * @var JWTService
     */
    private JWTService $jwtService;

    /**
     * Constructor del caso de uso.
     *
     * @param JWTService $jwtService Servicio encargado de la autenticación con JWT.
     */
    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Ejecuta la obtención del usuario autenticado desde el token.
     *
     * @return Usuario Instancia del usuario autenticado.
     *
     * @throws Exception Si no se puede obtener el usuario autenticado.
     */
    public function execute(): Usuario
    {
        $usuario = $this->jwtService->getAuthenticatedUser();
        if (!$usuario) {
            throw new Exception("No se pudo obtener el usuario autenticado", 401);
        }

        return $usuario;
    }
}
