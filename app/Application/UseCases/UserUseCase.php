<?php

namespace App\Application\UseCases;
use App\Models\Usuario;
use App\Domain\Models\Usuario as DomainUsuario;
use App\Infrastructure\Mappers\UsuarioMapper;

class UserUseCase
{
    public function ejecutar(): DomainUsuario
    {
        $eloquentUser = Usuario::find(1);
        $usuario = UsuarioMapper::toDomain($eloquentUser);
        if (!$usuario) {
            throw new \Exception('Usuario no encontrado');
        }
        return $usuario;
    }
}

