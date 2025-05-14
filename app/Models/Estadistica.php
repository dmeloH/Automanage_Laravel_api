<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estadistica
 * 
 * @property int $id
 * @property Carbon|null $fecha
 * @property int $inventario
 * @property int $usuariosRegistrados
 * @property int $vehiculosRevisados
 * @property int $ventas
 *
 * @package App\Models
 */
class Estadistica extends Model
{
	protected $table = 'estadisticas';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'inventario' => 'int',
		'usuariosRegistrados' => 'int',
		'vehiculosRevisados' => 'int',
		'ventas' => 'int'
	];

	protected $fillable = [
		'fecha',
		'inventario',
		'usuariosRegistrados',
		'vehiculosRevisados',
		'ventas'
	];
}
