<?php

namespace Modules\Financeiro\Models;

use App\Models\BaseModel;

class CupomDesconto extends BaseModel
{
	protected $table = 'financeiro.cupons_descontos';
	protected $fillable = [
		'nome',
		'codigo',
		'status',
		'valor',
		'tipo',
	];
}
