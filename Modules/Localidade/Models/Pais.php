<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pais extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'tb_pais';

    protected $fillable = [
    	'nome',
    	'sigla',
    	'nacionalidade',
	];
}
