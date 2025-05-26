<?php

namespace App\Application\UseCases;

use App\Models\Usuario;
use App\Domain\Models\Usuario as DomainUsuario;
use App\Infrastructure\Mappers\UsuarioMapper;

/**
 * Caso de uso para manejar operaciones relacionadas con el usuario.
 */
class UserUseCase
{
    /**
     * Ejecuta el caso de uso de obtención de un usuario específico (con ID 1).
     *
     * @throws \Exception Si el usuario no es encontrado.
     * @return DomainUsuario El usuario mapeado al modelo de dominio.
     */
    public function ejecutar(): DomainUsuario
    {
        // Busca el usuario en la base de datos usando Eloquent
        $eloquentUser = Usuario::find(1);

        // Mapea el modelo de Eloquent al modelo de dominio
        $usuario = UsuarioMapper::toDomain($eloquentUser);

        // Verifica si el usuario fue encontrado
        if (!$usuario) {
            throw new \Exception('Usuario no encontrado');
        }

        return $usuario;
    }
}
