<?php

namespace App\Application\UseCases;

use App\Infrastructure\Auth\JWTService;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RefreshTokenUseCase
{
    private JWTService $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function execute(): string
    {
        try {
            return $this->jwtService->refreshToken();
        } catch (TokenInvalidException $e) {
            throw new \Exception("Token inválido", 401);
        }
    }
}
 