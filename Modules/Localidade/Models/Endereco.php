<?php

namespace Modules\Localidade\Models;

use App\Models\BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Endereco extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'bairro_id',
        'cidade_id',
		'logradouro',
		'cep',
		'complemento',
		'numero',
		'tipo_endereco',
    ];

    public function bairro(){
        return $this->belongsTo(Bairro::class, 'bairro_id');
    }

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }
}
