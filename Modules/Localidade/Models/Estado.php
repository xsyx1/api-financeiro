<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Estado extends Model implements Transformable
{
    use TransformableTrait;


    protected $fillable = [
		'uf', 'nome','cod_ibje'
	];

	public function pais(){
		return $this->belongsTo(Pais::class, 'pais_id');
	}
}
