<?php

namespace App\Infrastructure\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Domain\Models\Usuario;
use App\Infrastructure\Mappers\UsuarioMapper;

/**
 * Servicio encargado de gestionar la autenticación JWT.
 */
class JWTService
{
    /**
     * Genera un token JWT para un usuario del dominio.
     *
     * @param Usuario $user El usuario del dominio para el cual se generará el token.
     * @return string El token JWT generado.
     */
    public function createToken(Usuario $user): string
    {
        // Convertir dominio a modelo Eloquent necesario para JWTAuth
        $eloquentUser = \App\Models\Usuario::find($user->getId());
        return JWTAuth::fromUser($eloquentUser);
    }

    /**
     * Intenta autenticar con las credenciales proporcionadas y retorna un token si tiene éxito.
     *
     * @param array $credentials Arreglo con 'email' y 'password'.
     * @return string|null El token JWT si la autenticación fue exitosa, o null si falló.
     */
    public function attempt(array $credentials): ?string
    {
        return JWTAuth::attempt($credentials);
    }

    /**
     * Invalida un token JWT, cerrando la sesión correspondiente.
     *
     * @param string $token El token que se desea invalidar.
     * @return void
     */
    public function invalidate(string $token): void
    {
        JWTAuth::setToken($token)->invalidate();
    }

    /**
     * Autentica y retorna el usuario asociado al token actual.
     *
     * @return mixed El modelo Eloquent del usuario autenticado, o null si no hay usuario.
     */
    public function parseToken()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    /**
     * Refresca el token JWT actual.
     *
     * @return string El nuevo token JWT.
     */
    public function refreshToken(): string
    {
        return JWTAuth::parseToken()->refresh();
    }

    /**
     * Obtiene el usuario autenticado y lo convierte al modelo de dominio.
     *
     * @return Usuario|null El usuario de dominio autenticado o null si no se encontró.
     */
    public function getAuthenticatedUser(): ?Usuario
    {
        $eloquentUser = JWTAuth::parseToken()->authenticate();
        return $eloquentUser ? UsuarioMapper::toDomain($eloquentUser) : null;
    }
}
