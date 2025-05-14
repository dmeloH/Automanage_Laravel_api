<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ordene
 * 
 * @property int $id
 * @property Carbon|null $fechacreacion
 * @property Carbon|null $fecharecibida
 * @property string|null $numero
 * @property float|null $total
 * @property int|null $usuario_id
 * 
 * @property Usuario|null $usuario
 * @property Collection|Detalle[] $detalles
 *
 * @package App\Models
 */
class Ordene extends Model
{
	protected $table = 'ordenes';
	public $timestamps = false;

	protected $casts = [
		'fechacreacion' => 'datetime',
		'fecharecibida' => 'datetime',
		'total' => 'float',
		'usuario_id' => 'int'
	];

	protected $fillable = [
		'fechacreacion',
		'fecharecibida',
		'numero',
		'total',
		'usuario_id'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function detalles()
	{
		return $this->hasMany(Detalle::class, 'orden_id');
	}
}
