<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property string|null $direccion
 * @property string|null $email
 * @property string|null $nombre
 * @property string|null $password
 * @property string|null $resetToken
 * @property string|null $telefono
 * @property string|null $tipo
 * @property string|null $username
 * 
 * @property Collection|Cita[] $citas
 * @property Collection|Ordene[] $ordenes
 * @property Collection|Producto[] $productos
 * @property Collection|Vehiculo[] $vehiculos
 *
 * @package App\Models
 */
class Usuario extends  Authenticatable  implements JWTSubject
{
	protected $table = 'usuarios';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'direccion',
		'email',
		'nombre',
		'password',
		'resetToken',
		'telefono',
		'role',
		'username'
	];

	public function citas()
	{
		return $this->hasMany(Cita::class);
	}

	public function ordenes()
	{
		return $this->hasMany(Ordene::class);
	}

	public function productos()
	{
		return $this->hasMany(Producto::class);
	}

	public function vehiculos()
	{
		return $this->hasMany(Vehiculo::class);
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [
			'role' => $this->role,
		];
	}
}
