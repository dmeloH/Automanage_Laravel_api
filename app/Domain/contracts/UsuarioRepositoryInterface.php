<?php
namespace App\Domain\contracts;

use App\Domain\Models\Usuario;

interface UsuarioRepositoryInterface
{
    public function save(Usuario $usuario): Usuario;
    public function login(string $email, string $password):?array;
    public function logout(): void;
    public function findByEmail(string $email): ?Usuario;
}
