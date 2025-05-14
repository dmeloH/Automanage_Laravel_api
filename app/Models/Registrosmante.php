<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Registrosmante
 * 
 * @property int $id
 * @property string|null $caracteristrica
 * @property string|null $fechaMante
 * @property string|null $imagen
 * @property string|null $nombre
 * @property int|null $precio
 * @property int|null $registroVehiculo_Id
 * 
 * @property Vehiculo|null $vehiculo
 *
 * @package App\Models
 */
class Registrosmante extends Model
{
	protected $table = 'registrosmante';
	public $timestamps = false;

	protected $casts = [
		'precio' => 'int',
		'registroVehiculo_Id' => 'int'
	];

	protected $fillable = [
		'caracteristrica',
		'fechaMante',
		'imagen',
		'nombre',
		'precio',
		'registroVehiculo_Id'
	];

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'registroVehiculo_Id');
	}
}
