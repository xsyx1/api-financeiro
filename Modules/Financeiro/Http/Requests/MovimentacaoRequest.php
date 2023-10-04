<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Financeiro\Enuns\Indice;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class MovimentacaoRequest extends BaseRequest implements ICustomRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		return [
			"lancamento_financeiro_id",
			"conta_financeira_id",
			"tipo_movimentacao",
			"tipo",
			"valor",
			"meio_pagamento",
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return  bool
	 */
	public function authorize()
	{
		return true;
	}

	public function getOnlyFields()
	{
		return [
			"lancamento_financeiro_id",
			"conta_financeira_id",
			"tipo_movimentacao",
			"tipo",
			"valor",
			"meio_pagamento",
		];
	}
}
