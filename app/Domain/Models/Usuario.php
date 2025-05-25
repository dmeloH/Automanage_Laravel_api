<?php

namespace App\Domain\Models;

use Illuminate\Support\Facades\Hash;

class Usuario
{
    private int $id;
    private ?string $direccion;
    private ?string $email;
    private ?string $nombre;
    private ?string $password;
    private ?string $resetToken;
    private ?string $telefono;
    private ?string $role;
    private ?string $username;

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

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getNombre(): ?string
    {
        return $this->nombre;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }
    public function getRole(): ?string
    {
        return $this->role;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    // Setters (si necesitas mutabilidad)
    public function setDireccion(?string $direccion): void
    {
        $this->direccion = $direccion;
    }
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }
    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function esAdministrador(): bool
{
    // Adjust the logic as needed based on your application's role structure
    return $this->getRole() === 'admin';
}

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
