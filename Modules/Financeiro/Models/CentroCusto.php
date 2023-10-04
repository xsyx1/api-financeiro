<?php

namespace Modules\Financeiro\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class CentroCusto extends BaseModel
{
	use SoftDeletes;

	protected $fillable = [
		'nome',
		'status',
		'codigo',
		'cor',
		'recebe_lancamento',
		'tipo',
		'parent_id',
		'filial_id',
	];
	public function filhos(){
        return $this->hasMany(CentroCusto::class, 'parent_id');
    }
	public function filial(){
		return $this->belongsTo(Filial::class, 'filial_id');
	}

}
