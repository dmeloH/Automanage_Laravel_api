<?php

namespace App\Application\UseCases;

use App\Domain\Contracts\UsuarioRepositoryInterface;

/**
 * Caso de uso para cerrar la sesión del usuario autenticado.
 */
class LogoutUserUseCase
{
    /**
     * Repositorio de autenticación de usuarios.
     *
     * @var UsuarioRepositoryInterface
     */
    private UsuarioRepositoryInterface $authRepo;

    /**
     * Constructor del caso de uso.
     *
     * @param UsuarioRepositoryInterface $authRepo Repositorio encargado de manejar la sesión del usuario.
     */
    public function __construct(UsuarioRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    /**
     * Ejecuta el cierre de sesión del usuario actual.
     *
     * @return void
     */
    public function execute(): void
    {
        $this->authRepo->logout();
    }
}
