<?php
namespace App\Infrastructure\Mappers;

use App\Models\Usuario as EloquentUsuario;
use App\Domain\Models\Usuario as DomainUsuario;

class UsuarioMapper
{
    public static function toDomain(EloquentUsuario $eloquent): DomainUsuario
    {
        return new DomainUsuario(
            [$eloquent->id],
            $eloquent->direccion,
            $eloquent->email,
            $eloquent->nombre,
            $eloquent->password,
            $eloquent->resetToken,
            $eloquent->telefono,
            $eloquent->role,
            $eloquent->username
        );
    }

    public static function toEloquent(DomainUsuario $usuario): EloquentUsuario
    {
        $eloquent = new EloquentUsuario();
        $eloquent->id = $usuario->getId();
        $eloquent->direccion = $usuario->getDireccion();
        $eloquent->email = $usuario->getEmail();
        $eloquent->nombre = $usuario->getNombre();
        $eloquent->password = $usuario->getPassword();
        $eloquent->resetToken = $usuario->getResetToken();
        $eloquent->telefono = $usuario->getTelefono();
        $eloquent->role = $usuario->getRole();
        $eloquent->username = $usuario->getUsername();
        return $eloquent;
    }
}
