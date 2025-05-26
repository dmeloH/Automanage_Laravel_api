<?php

namespace App\Infrastructure\Repositories;

use App\Domain\contracts\UsuarioRepositoryInterface;
use App\Domain\Models\Usuario;
use App\Models\Usuario as EloquentUsuario;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Implementación del repositorio de usuarios utilizando Eloquent ORM.
 */
class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    /**
     * Guarda un usuario en la base de datos. Si ya existe, lo actualiza.
     *
     * @param Usuario $usuario El usuario de dominio a guardar.
     * @return Usuario El usuario actualizado con los datos persistidos.
     */
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
     * Busca un usuario por su correo electrónico.
     *
     * @param string $email El correo electrónico del usuario.
     * @return Usuario|null El usuario encontrado o null si no existe.
     */
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
     * Autentica un usuario con sus credenciales y genera un token JWT.
     *
     * @param string $email El correo electrónico del usuario.
     * @param string $password La contraseña del usuario.
     * @return array|null Datos del usuario autenticado y token, o null si falla la autenticación.
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

    /**
     * Invalida el token JWT del usuario autenticado, cerrando su sesión.
     *
     * @return void
     */
    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
