<?php
namespace App\Application\UseCases;

use App\Domain\contracts\UsuarioRepositoryInterface;
use App\Domain\Models\Usuario;
use App\Infrastructure\Auth\JWTService;
use Illuminate\Support\Facades\Hash;

class RegisterUserUseCase
{
    private UsuarioRepositoryInterface $userRepo;
    private JWTService $jwtService;

    public function __construct(UsuarioRepositoryInterface $userRepo, JWTService $jwtService)
    {
        $this->userRepo = $userRepo;
        $this->jwtService = $jwtService;
    }

    public function execute(array $data): array
    {
        // Aquí puedes hacer validaciones manuales o usar validadores separados

        if ($this->userRepo->findByEmail($data['email'])) {
            throw new \Exception('El correo electrónico ya está en uso');
        }

        $usuario = Usuario::createFromArray($data);
        if (!$usuario) {
            throw new \Exception('Error al crear el usuario');
        }
        $usuarioGuardado = $this->userRepo->save($usuario);

        $token = $this->jwtService->createToken($usuarioGuardado);

        return [
            'user' => $usuarioGuardado,
            'token' => $token
        ];
    }

}

