<?php

namespace App\Application\UseCases;

use App\Domain\Contracts\UsuarioRepositoryInterface;

class LogoutUserUseCase
{
    private UsuarioRepositoryInterface $authRepo;

    public function __construct(UsuarioRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function execute(): void
    {
        $this->authRepo->logout();
    }
}
