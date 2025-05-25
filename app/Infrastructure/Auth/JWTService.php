<?php

namespace App\Infrastructure\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Domain\Models\Usuario;
use App\Infrastructure\Mappers\UsuarioMapper;

class JWTService
{
    public function createToken(Usuario $user): string
    {
        // convertir dominio a modelo eloquent necesario para JWTAuth
        $eloquentUser = \App\Models\Usuario::find($user->getId());
        return JWTAuth::fromUser($eloquentUser);
    }

    public function attempt(array $credentials): ?string
    {
        return JWTAuth::attempt($credentials);
    }

    public function invalidate(string $token): void
    {
        JWTAuth::setToken($token)->invalidate();
    }

    public function parseToken()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function refreshToken(): string
    {
        return JWTAuth::parseToken()->refresh();
    }
    public function getAuthenticatedUser(): ?Usuario
    {
        $eloquentUser = JWTAuth::parseToken()->authenticate();
        return $eloquentUser ? UsuarioMapper::toDomain($eloquentUser) : null;
    }
}
