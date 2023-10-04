<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Financeiro\Enuns\TipoPlanoConta;
use Modules\Financeiro\Rules\PlanoContaCheckTipo;
use Modules\Financeiro\Services\PlanoContaService;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;
use App\Rules\HexadecimalRule;
use Symfony\Component\HttpFoundation\ParameterBag;

class PlanoContaRequest extends BaseRequest implements ICustomRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		return [
            'parent_id' => 'integer|exists:plano_contas,id',
			'nome' => 'required|string',
			'codigo' => 'unique:plano_contas,codigo'.(($id)?','.$id.',id':''),
			'status' => 'required|boolean',
			'cores' => [
				new HexadecimalRule()
			],
			'recebe_lancamento' => 'required|boolean',
			'tipo' => [
				'required',
				new PlanoContaCheckTipo(PlanoContaService::class, $this->getField('tipo'), $this->getField('parent_id')),
				new EnumRule(TipoPlanoConta::class)
			],

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
            'parent_id',
			'nome',
			'status',
			'cor',
			'recebe_lancamento',
			'tipo',
			'contabil',
			'codigo'
		];
	}
}
