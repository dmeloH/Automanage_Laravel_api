<?php

namespace App\Application\UseCases;

use App\Domain\Contracts\UsuarioRepositoryInterface;

/**
 * Caso de uso para iniciar sesión de usuario.
 */
class LoginUserUseCase
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
     * @param UsuarioRepositoryInterface $authRepo Repositorio responsable de la autenticación.
     */
    public function __construct(UsuarioRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    /**
     * Ejecuta el inicio de sesión del usuario.
     *
     * @param string $email Correo electrónico del usuario.
     * @param string $password Contraseña del usuario.
     * @return array|null Datos del usuario autenticado (ej. token, info) o null si falla.
     */
    public function execute(string $email, string $password): ?array
    {
        return $this->authRepo->login($email, $password);
    }
}
