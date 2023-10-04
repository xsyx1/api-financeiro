<?php

namespace Modules\Core\Models;

use Illuminate\Notifications\Notifiable;
use Modules\Financeiro\Models\Cliente;
use Modules\Saude\Models\Beneficiario;
use Modules\Saude\Models\PrestadorServico;
use App\Models\BaseModel;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Models\Telefone;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pessoa extends BaseModel implements Transformable
{
	use Notifiable, TransformableTrait;

	const PESSOA_FISICA = 'F';
	const PESSOA_JURIDICA = 'J';


	protected $fillable = [
		'nome',
		'email',
		'cpf_cnpj',
		'estado_civil',
		'regime_uniao',
		'data_nascimento',
		'sexo',
		'rg',
		'filiacao_mae',
		'razao_social',
		'inscricao_municipal',
		'inscricao_estadual',
		'data_fundacao',
		'descricao',
		'naturalidade_id',
		'filiacao_pai'
	];

	public function setCpfCnpjAttribute($value)
	{
		if ($value)
			$this->attributes['cpf_cnpj'] = preg_replace('([\.\-\/])', '', $value);
	}

	public function tipo()
	{
		return (validar_cnpj($this->attributes['cpf_cnpj'])) ? self::PESSOA_JURIDICA : self::PESSOA_FISICA;
	}
	public function usuario()
	{
		return $this->hasOne(User::class, 'pessoa_id');
	}
	public function prestador_servicos()
	{
		return $this->hasMany(PrestadorServico::class, 'pessoa_id');
	}
	public function beneficiarios()
	{
		return $this->hasMany(Beneficiario::class, 'pessoa_id');
	}
	public function clientes()
	{
		return $this->hasMany(Cliente::class, 'pessoa_id');
	}

    public function telefones(){
    	return $this->hasMany(Telefone::class, 'pessoa_id');
	}

	public function enderecos(){
		return $this->morphMany(Endereco::class, 'enderecotable');
	}
}
