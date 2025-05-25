<?php

namespace App\Infrastructure\Repositories;

use App\Domain\contracts\UsuarioRepositoryInterface;
use App\Domain\Models\Usuario;
use App\Models\Usuario as EloquentUsuario;
use Tymon\JWTAuth\Facades\JWTAuth;

class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    public function save(Usuario $usuario): Usuario
    {
        $eloquent = $usuario->getId() ? EloquentUsuario::find($usuario->getId()) : new EloquentUsuario();

        $eloquent->nombre = $usuario->getNombre();
        $eloquent->email = $usuario->getEmail();
        $eloquent->password = $usuario->getPassword();
        $eloquent->telefono = $usuario->getTelefono();
        $eloquent->direccion = $usuario->getDireccion();
        $eloquent->role = $usuario->getRole();
        $eloquent->username = $usuario->getUsername();

        $eloquent->save();

        // Devolver un nuevo Usuario actualizado
        return new Usuario(
            $eloquent->id,
            $eloquent->direccion,
            $eloquent->email,
            $eloquent->nombre,
            $eloquent->password,
            null, // resetToken
            $eloquent->telefono,
            $eloquent->role,
            $eloquent->username
        );
    }

    public function findByEmail(string $email): ?Usuario
    {
        $eloquent = EloquentUsuario::where('email', $email)->first();
        if (!$eloquent) return null;

        return new Usuario(
            $eloquent->id,
            $eloquent->direccion,
            $eloquent->email,
            $eloquent->nombre,
            $eloquent->password,
            null, // resetToken
            $eloquent->telefono,
            $eloquent->role,
            $eloquent->username
        );
    }

    /**
     * @return array|null
     */
    public function login(string $email, string $password): ?array
    {
        $credentials = ['email' => $email, 'password' => $password];

        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }

        return [
            'user' => JWTAuth::user(),
            'token' => $token,
        ];
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
