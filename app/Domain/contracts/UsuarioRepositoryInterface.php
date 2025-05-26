<?php

namespace App\Domain\contracts;

use App\Domain\Models\Usuario;

/**
 * Interface UsuarioRepositoryInterface
 *
 * Define los métodos necesarios para la persistencia y autenticación de usuarios.
 */
interface UsuarioRepositoryInterface
{
    /**
     * Guarda un usuario en el repositorio.
     *
     * @param Usuario $usuario Instancia del usuario a guardar.
     * @return Usuario Usuario guardado (posiblemente con ID actualizado).
     */
    public function save(Usuario $usuario): Usuario;

    /**
     * Intenta iniciar sesión con las credenciales proporcionadas.
     *
     * @param string $email Correo electrónico del usuario.
     * @param string $password Contraseña del usuario.
     * @return array|null Información del usuario autenticado o null si falla.
     */
    public function login(string $email, string $password): ?array;

    /**
     * Cierra la sesión del usuario actual.
     *
     * @return void
     */
    public function logout(): void;

    /**
     * Busca un usuario por su correo electrónico.
     *
     * @param string $email Correo electrónico a buscar.
     * @return Usuario|null Usuario encontrado o null si no existe.
     */
    public function findByEmail(string $email): ?Usuario;
}
