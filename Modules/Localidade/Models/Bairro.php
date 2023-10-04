<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Localidade\Models\Bairro
 *
 * @property int $id
 * @property int $cidade_id
 * @property string $titulo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Bairro whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Bairro whereCidadeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Bairro whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Bairro whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Localidade\Models\Bairro whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bairro extends Model implements Transformable
{
    use TransformableTrait;


    protected $fillable = [
    	'cidade_id',
		'nome'
	];

	public function cidade(){
		return $this->belongsTo(Cidade::class, 'cidade_id');
	}
}
