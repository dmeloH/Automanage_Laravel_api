<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Detalle
 * 
 * @property int $id
 * @property float|null $cantidad
 * @property string|null $nombre
 * @property float|null $precio
 * @property float|null $total
 * @property int|null $orden_id
 * @property int|null $producto_id
 * 
 * @property Ordene|null $ordene
 * @property Producto|null $producto
 *
 * @package App\Models
 */
class Detalle extends Model
{
	protected $table = 'detalles';
	public $timestamps = false;

	protected $casts = [
		'cantidad' => 'float',
		'precio' => 'float',
		'total' => 'float',
		'orden_id' => 'int',
		'producto_id' => 'int'
	];

	protected $fillable = [
		'cantidad',
		'nombre',
		'precio',
		'total',
		'orden_id',
		'producto_id'
	];

	public function ordene()
	{
		return $this->belongsTo(Ordene::class, 'orden_id');
	}

	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}
}
