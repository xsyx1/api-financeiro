<?php

namespace Modules\Financeiro\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use Modules\Financeiro\Rules\IsParceladoRule;
use Modules\Financeiro\Rules\LancamentoBaixadoRule;
use Modules\Financeiro\Rules\ValidateDeleteAtRule;

class ParcelaAvulsaRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		return [
			"valor_original" => "required",
			"descricao" => "nullable|string|max:1000",
			"data_vencimento" => "required",
			"cliente_id" => "nullable|exists:clientes,id",
			"plano_conta_id" => "nullable|exists:plano_contas,id",
			"centro_custo_id" => "nullable|exists:centro_custos,id",
			"conta_financeiro_id" => "required|exists:conta_financeiros,id",
			'lancamento_id' => [
				'required',
				'integer',
				'exists:lancamento_financeiros,id',
				new LancamentoBaixadoRule(),
                new ValidateDeleteAtRule('financeiro.lancamento_financeiros')
            ]
		];
	}



	public function getOnlyFields()
	{
		return [
            "lancamento_id",
            "parent_id",
			"filial_id",
			"plano_conta_id",
			"centro_custo_id",
			"conta_financeiro_id",
			"cliente_id",
			"usuario_id",
			"tipo_documento",
			"data_arq_remessa",
			"data_baixa",
			"data_conciliacao",
			"data_efetivacao",
			"data_emissao",
			"data_ult_cobranca",
			"data_vencimento",
			'data_vencimento_renegociacao',
            'data_pagamento',
			"descricao",
			"num_parcela",
			"protocolar",
			"qtd_dias_carencia_juros",
			"qtd_dias_carencia_multa",
			"recorrente",
			"situacao_lancamento",
			"taxa_correcao_monetaria",
			"taxa_juros",
			"taxa_multa",
			"valor_original",
			"saldo",
			"valor_correcao_monetaria",
			"valor_desconto",
			"valor_juros",
			"valor_multa",
			"valor_outros",
			"valor_taxa_bancaria",
			"tipo",
			"modulo",
            'descricao_caixa',
            'historico',
            'numero_documento',
            'status_lancamento',
            'origem_lancamento',
        ];
	}

	public function messages()
    {
        return [
			'lancamento_id.required' => 'Lançamento não informado!',
			'cliente_id.exists' => 'Cliente não encontrado!',
			'plano_conta_id.exists' => 'Plano de contas não encontrado!',
			'centro_custo_id.exists' => 'Centro de custo não encontrado!',
            'lancamento_id.exists' => 'Lançamento financeiro não encontrado!',
            'conta_financeiro_id.exists' => 'Conta financeira não encontrada!',
            'valor_original.required' => 'O valor da parcela não foi informada',
        ];
    }
}
