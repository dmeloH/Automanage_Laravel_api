<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cita
 * 
 * @property int $id
 * @property string|null $caracteristicas
 * @property Carbon|null $fechaCita
 * @property Carbon|null $fechaPeticion
 * @property int|null $registroVehiculo_Id
 * @property int|null $usuario_id
 * 
 * @property Usuario|null $usuario
 * @property Vehiculo|null $vehiculo
 *
 * @package App\Models
 */
class Cita extends Model
{
	protected $table = 'citas';
	public $timestamps = false;

	protected $casts = [
		'fechaCita' => 'datetime',
		'fechaPeticion' => 'datetime',
		'registroVehiculo_Id' => 'int',
		'usuario_id' => 'int'
	];

	protected $fillable = [
		'caracteristicas',
		'fechaCita',
		'fechaPeticion',
		'registroVehiculo_Id',
		'usuario_id'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'registroVehiculo_Id');
	}
}
