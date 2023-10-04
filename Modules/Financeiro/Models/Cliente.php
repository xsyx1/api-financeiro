<?php

namespace Modules\Financeiro\Models;

use Modules\Core\Models\Anexo;
use Modules\Core\Models\Pessoa;
use App\Models\BaseModel;

class Cliente extends BaseModel
{
	protected $fillable = [
		"pessoa_id",
		"status",
		"filial_id",
		"customer_id",
	];

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'pessoa_id');
	}
	public function anexo()
	{
		return $this->morphMany(Anexo::class, 'anexotable');
	}
	public function assinaturas()
	{
		return $this->hasMany(Assinaturas::class, 'cliente_id');
	}
	public function cartoes()
	{
		return $this->hasMany(Cartao::class, 'cliente_id');
	}

	public function cliente_beneficiario() {
		return $this->hasMany(ClienteBeneficiario::class);
	}
}
