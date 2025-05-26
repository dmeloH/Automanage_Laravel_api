<?php

namespace App\Application\UseCases;

use App\Domain\contracts\UsuarioRepositoryInterface;
use App\Domain\Models\Usuario;
use App\Infrastructure\Auth\JWTService;
use Illuminate\Support\Facades\Hash;
use Exception;

/**
 * Caso de uso para registrar un nuevo usuario en el sistema.
 */
class RegisterUserUseCase
{
    /**
     * Repositorio de usuarios.
     *
     * @var UsuarioRepositoryInterface
     */
    private UsuarioRepositoryInterface $userRepo;

    /**
     * Servicio para generar tokens JWT.
     *
     * @var JWTService
     */
    private JWTService $jwtService;

    /**
     * Constructor del caso de uso.
     *
     * @param UsuarioRepositoryInterface $userRepo Repositorio de usuarios.
     * @param JWTService $jwtService Servicio de tokens JWT.
     */
    public function __construct(UsuarioRepositoryInterface $userRepo, JWTService $jwtService)
    {
        $this->userRepo = $userRepo;
        $this->jwtService = $jwtService;
    }

    /**
     * Ejecuta el caso de uso de registro de usuario.
     *
     * @param array $data Datos del nuevo usuario.
     * @return array Contiene el usuario registrado y el token JWT generado.
     *
     * @throws Exception Si el correo ya existe o hay un error al crear el usuario.
     */
    public function execute(array $data): array
    {
        // Verifica si el email ya está registrado
        if ($this->userRepo->findByEmail($data['email'])) {
            throw new Exception('El correo electrónico ya está en uso');
        }

        // Crea el usuario desde los datos proporcionados
        $usuario = Usuario::createFromArray($data);
        if (!$usuario) {
            throw new Exception('Error al crear el usuario');
        }

        // Guarda el usuario en el repositorio
        $usuarioGuardado = $this->userRepo->save($usuario);

        // Genera el token JWT para el usuario
        $token = $this->jwtService->createToken($usuarioGuardado);

        return [
            'user' => $usuarioGuardado,
            'token' => $token
        ];
    }
}
