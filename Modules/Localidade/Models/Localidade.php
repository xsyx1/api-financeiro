<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Localidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'cep','estado_id','cidade_id','logradouro'
    ];

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

}
