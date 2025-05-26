<?php

namespace App\Application\UseCases;

use App\Infrastructure\Auth\JWTService;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;

/**
 * Caso de uso para refrescar un token JWT válido.
 */
class RefreshTokenUseCase
{
    /**
     * Servicio JWT encargado de la autenticación.
     *
     * @var JWTService
     */
    private JWTService $jwtService;

    /**
     * Constructor del caso de uso.
     *
     * @param JWTService $jwtService Servicio encargado de operaciones con JWT.
     */
    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Ejecuta la lógica para refrescar un token JWT.
     *
     * @return string El nuevo token JWT.
     *
     * @throws Exception Si el token actual no es válido.
     */
    public function execute(): string
    {
        try {
            return $this->jwtService->refreshToken();
        } catch (TokenInvalidException $e) {
            throw new Exception("Token inválido", 401);
        }
    }
}
