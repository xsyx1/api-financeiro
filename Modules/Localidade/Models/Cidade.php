<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Localidade\Models\Cidade
 *
 * @property int $id
 * @property int $estado_id
 * @property string $titulo
 * @property bool $capital
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereEstadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereCapital($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Cidade whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cidade extends Model implements Transformable
{
    use TransformableTrait;
    protected $fillable = [
        'estado_id',
		'cod_cidade',
		'nome',
		'capital',
		'cod_ibje',
    ];

	public function estado(){
		return $this->belongsTo(Estado::class, 'estado_id');
	}
}
