<?php

namespace Modules\Financeiro\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class PlanoConta extends BaseModel
{
	use SoftDeletes;

	protected $fillable = [
        "parent_id",
		"nome",
		"cor",
		"status",
		"tipo",
		"recebe_lancamento",
		"codigo",
		"filial_id",
		"contabil",
	];

    public function filhos(){
        return $this->hasMany(PlanoConta::class, 'parent_id');
    }
	public function filial(){
		return $this->belongsTo(Filial::class, 'filial_id');
	}
}
