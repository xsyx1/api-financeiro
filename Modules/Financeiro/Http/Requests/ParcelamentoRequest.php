<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Financeiro\Enuns\Indice;
use Modules\Financeiro\Enuns\Periodicidade;
use Modules\Financeiro\Rules\LancamentoBloqueadoRule;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;
use Modules\Financeiro\Rules\IsParceladoRule;
use Modules\Financeiro\Rules\LancamentoBaixadoRule;

class ParcelamentoRequest extends BaseRequest implements ICustomRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		return [
			"lancamento_id" => [
				'required',
				'exists:lancamento_financeiros,id',
				new LancamentoBaixadoRule(),
				new IsParceladoRule()
			],
			"num_parcela" => "required|integer|min:1|max:500",
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
			'num_parcela',
			'lancamento_id',
		];
	}

	public function messages() {
		return [
			'lancamento_id.exists' => 'Lançamento financeiro não encontrado',
			'num_parcela.required' => 'O número de parcelas não foi informado!'
		];
	}
}
