<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id
 * @property int|null $cantidad
 * @property string|null $descripcion
 * @property string|null $imagen
 * @property string|null $nombre
 * @property float|null $precio
 * @property int|null $usuario_id
 * 
 * @property Usuario|null $usuario
 * @property Collection|Detalle[] $detalles
 *
 * @package App\Models
 */
class Producto extends Model
{
	protected $table = 'productos';
	public $timestamps = false;

	protected $casts = [
		'cantidad' => 'int',
		'precio' => 'float',
		'usuario_id' => 'int'
	];

	protected $fillable = [
		'cantidad',
		'descripcion',
		'imagen',
		'nombre',
		'precio',
		'usuario_id'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function detalles()
	{
		return $this->hasMany(Detalle::class);
	}
}
