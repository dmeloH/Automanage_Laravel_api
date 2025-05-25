<?php

namespace App\Application\UseCases;

use App\Domain\Contracts\UsuarioRepositoryInterface;

class LoginUserUseCase
{
    private UsuarioRepositoryInterface $authRepo;

    public function __construct(UsuarioRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function execute(string $email, string $password): ?array
    {
        return $this->authRepo->login($email, $password);
    }
}
