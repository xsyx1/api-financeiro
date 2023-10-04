<?php

namespace Modules\Localidade\Models;

use Modules\Core\Models\Pessoa;
use Modules\Localidade\Enuns\TipoTelefone;
use App\Models\BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Telefone extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'ddd',
        'numero',
        'pessoa_id',
        'observacao',
        'tipo_telefone',
    ];

    /*public function setNumeroAttribute($value)
    {
        if ($value)
            $this->attributes['numero'] =  preg_replace('/[^0-9]/', '', $value);
    }*/

   /* public function getNumeroAttribute($value)
    {
        if ($value)
            return mask($value, "(##) #####-####");
    }*/

	public function pessoa(){
		return $this->belongsTo(Pessoa::class, 'pessoa_id');
	}

	public function tipo_telefone(){
		$tipo_telefone = $this->getAttribute('tipo_telefone');
		if(is_null($tipo_telefone)){
			return null;
		}
		return  (new TipoTelefone($tipo_telefone))->toArray();
	}
}
