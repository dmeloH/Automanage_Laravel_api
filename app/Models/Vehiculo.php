<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiculo
 *
 * @property int $Id
 * @property int|null $cilindraje
 * @property string|null $imagen
 * @property string|null $marca
 * @property int|null $modelo
 * @property string|null $nombre
 * @property string|null $placa
 * @property int|null $usuario_id
 *
 * @property Usuario|null $usuario
 * @property Collection|Cita[] $citas
 * @property Collection|Registrosmante[] $registrosmantes
 *
 * @package App\Models
 */
class Vehiculo extends Model
{
	protected $table = 'vehiculos';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'cilindraje' => 'int',
		'modelo' => 'int',
		'usuario_id' => 'int'
	];

	protected $fillable = [
		'cilindraje',
		'imagen',
		'marca',
		'modelo',
		'nombre',
		'placa',
		'usuario_id'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function citas()
	{
		return $this->hasMany(Cita::class, 'registroVehiculo_Id');
	}

	public function registrosmantes()
	{
		return $this->hasMany(Registrosmante::class, 'registroVehiculo_Id');
	}
}
