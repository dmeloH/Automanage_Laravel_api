<?php

namespace App\Domain\Models;

use Illuminate\Support\Facades\Hash;

/**
 * Clase Usuario que representa un usuario dentro del dominio de la aplicación.
 */
class Usuario
{
    /**
     * ID del usuario.
     *
     * @var int
     */
    private int $id;

    /**
     * Dirección del usuario.
     *
     * @var string|null
     */
    private ?string $direccion;

    /**
     * Correo electrónico del usuario.
     *
     * @var string|null
     */
    private ?string $email;

    /**
     * Nombre completo del usuario.
     *
     * @var string|null
     */
    private ?string $nombre;

    /**
     * Contraseña (hashed) del usuario.
     *
     * @var string|null
     */
    private ?string $password;

    /**
     * Token de reseteo de contraseña.
     *
     * @var string|null
     */
    private ?string $resetToken;

    /**
     * Teléfono del usuario.
     *
     * @var string|null
     */
    private ?string $telefono;

    /**
     * Rol del usuario (ej. admin, user, etc.).
     *
     * @var string|null
     */
    private ?string $role;

    /**
     * Nombre de usuario.
     *
     * @var string|null
     */
    private ?string $username;

    /**
     * Constructor de la clase Usuario.
     *
     * @param array $attributes Atributos del usuario.
     */
    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->direccion = $attributes['direccion'] ?? null;
        $this->email = $attributes['email'] ?? null;
        $this->nombre = $attributes['nombre'] ?? null;
        $this->password = $attributes['password'] ?? null;
        $this->resetToken = $attributes['resetToken'] ?? null;
        $this->telefono = $attributes['telefono'] ?? null;
        $this->role = $attributes['role'] ?? null;
        $this->username = $attributes['username'] ?? null;
    }

    /**
     * Obtiene el ID del usuario.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtiene la dirección del usuario.
     *
     * @return string|null
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * Obtiene el correo electrónico del usuario.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Obtiene el nombre del usuario.
     *
     * @return string|null
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Obtiene la contraseña (hashed) del usuario.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Obtiene el token de reseteo de contraseña.
     *
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * Obtiene el teléfono del usuario.
     *
     * @return string|null
     */
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    /**
     * Obtiene el rol del usuario.
     *
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Obtiene el nombre de usuario.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Establece la dirección del usuario.
     *
     * @param string|null $direccion
     * @return void
     */
    public function setDireccion(?string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * Establece el nombre del usuario.
     *
     * @param string|null $nombre
     * @return void
     */
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * Establece el correo electrónico del usuario.
     *
     * @param string|null $email
     * @return void
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * Establece la contraseña del usuario.
     *
     * @param string|null $password
     * @return void
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * Establece el token de reseteo de contraseña.
     *
     * @param string|null $resetToken
     * @return void
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    /**
     * Establece el teléfono del usuario.
     *
     * @param string|null $telefono
     * @return void
     */
    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * Establece el rol del usuario.
     *
     * @param string|null $role
     * @return void
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    /**
     * Establece el nombre de usuario.
     *
     * @param string|null $username
     * @return void
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * Verifica si el usuario es administrador.
     *
     * @return bool
     */
    public function esAdministrador(): bool
    {
        return $this->getRole() === 'admin';
    }

    /**
     * Crea una instancia de Usuario desde un arreglo de datos.
     *
     * @param array $data Datos del usuario.
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        return new self([
            'id' => 0,
            'direccion' => $data['direccion'] ?? null,
            'email' => $data['email'] ?? null,
            'nombre' => $data['nombre'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
            'resetToken' => null,
            'telefono' => $data['telefono'] ?? null,
            'role' => $data['role'] ?? null,
            'username' => $data['username'] ?? null,
        ]);
    }
}
