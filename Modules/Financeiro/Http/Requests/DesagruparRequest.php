<?php

namespace Modules\Financeiro\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use Modules\Financeiro\Rules\DesagruparRule;
use Modules\Financeiro\Rules\ValidacaoAgrupadorRule;

class DesagruparRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		return [
			'agrupados' => [
				'required',
			],
			'agrupados.*' => [
				'required',
				'integer',
				'exists:lancamento_financeiros,id',
				new DesagruparRule()
			]
		];
	}



	public function getOnlyFields()
	{
		return [
            'agrupados'
		];
	}

	public function messages()
    {
        return [
            'agrupados.*.exists' => 'Lançamento financeiro não encontrado!',
        ];
    }
}
