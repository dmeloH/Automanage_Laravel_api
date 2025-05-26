<?php

namespace App\Infrastructure\Mappers;

use App\Models\Usuario as EloquentUsuario;
use App\Domain\Models\Usuario as DomainUsuario;

/**
 * Clase responsable de mapear datos entre el modelo de dominio y el modelo Eloquent.
 */
class UsuarioMapper
{
    /**
     * Convierte un modelo EloquentUsuario en un modelo de dominio DomainUsuario.
     *
     * @param EloquentUsuario $eloquent El modelo Eloquent del usuario.
     * @return DomainUsuario El modelo de dominio equivalente.
     */
    public static function toDomain(EloquentUsuario $eloquent): DomainUsuario
    {
        return new DomainUsuario(
            [$eloquent->id], // Asegúrate de que el constructor del dominio espera un array si esto es intencional.
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

    /**
     * Convierte un modelo de dominio DomainUsuario en un modelo EloquentUsuario.
     *
     * @param DomainUsuario $usuario El modelo de dominio del usuario.
     * @return EloquentUsuario El modelo Eloquent equivalente.
     */
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
