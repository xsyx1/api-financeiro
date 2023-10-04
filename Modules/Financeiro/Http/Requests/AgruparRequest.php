<?php

namespace Modules\Financeiro\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Rules\EnumRule;
use Modules\Core\Enuns\Modulo;
use Modules\Financeiro\Enuns\TipoDocumento;
use Modules\Financeiro\Enuns\TipoLancamento;
use Modules\Financeiro\Rules\IsParceladoRule;
use Modules\Financeiro\Rules\LancamentoBaixadoRule;
use Modules\Financeiro\Rules\ValidacaoAgrupadorRule;
use Modules\Financeiro\Rules\ValidacaoEqualTypeAgrupadorRule;

class AgruparRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		return [
			"descricao" => "nullable|string|max:1000",
			"tipo_documento" => [
				"nullable",
				new EnumRule(TipoDocumento::class)
			],
			"modulo" => [
				"required",
				new EnumRule(Modulo::class)
			],
			"data_vencimento" => "required",
			"cliente_id" => "nullable|exists:clientes,id",
			"plano_conta_id" => "nullable|exists:plano_contas,id",
			"centro_custo_id" => "nullable|exists:centro_custos,id",
			"conta_financeiro_id" => "nullable|exists:conta_financeiros,id",
			'agrupados' => [
				'required',
				'array',
				new ValidacaoAgrupadorRule(),
                new ValidacaoEqualTypeAgrupadorRule()
			],
			'agrupados.*' => [
				'required',
				'integer',
				'exists:lancamento_financeiros,id',
				new LancamentoBaixadoRule(),
				new IsParceladoRule()
			]
		];
	}



	public function getOnlyFields()
	{
		return [
			"plano_conta_id",
			"centro_custo_id",
			"conta_financeiro_id",
			"cliente_id",
			"tipo_documento",
			"descricao",
			"protocolar",
			"valor_original",
			"tipo",
			"modulo",
            'descricao',
            'agrupados',
			'data_vencimento'
		];
	}

	public function messages()
    {
        return [
			'modulo.required' => 'Modulo não informado!',
			'cliente_id.exists' => 'Cliente não encontrado!',
			'plano_conta_id.exists' => 'Plano de contas não encontrado!',
			'centro_custo_id.exists' => 'Centro de custo não encontrado!',
            'agrupados.*.exists' => 'Lançamento financeiro não encontrado!',
            'conta_financeiro_id.exists' => 'Conta financeira não encontrada!',
            'tipo.required' => 'Tipo de lançamento não informado!',
            'descricao.required' => 'A descrição da baixa não foi informada',
            'descricao.max:1000' => 'O tamanho maximo da descrição é de 1000 caracteres!'
        ];
    }
}
