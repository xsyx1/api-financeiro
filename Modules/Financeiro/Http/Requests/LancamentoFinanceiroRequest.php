<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Core\Enuns\Modulo;
use Modules\Financeiro\Enuns\SituacaoLancamento;
use Modules\Financeiro\Enuns\TipoDocumento;
use Modules\Financeiro\Enuns\TipoLancamento;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class LancamentoFinanceiroRequest extends BaseRequest implements ICustomRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		$id = $this->getIdentificador('lancamentofinanceiro');
		return [
			"valor_original" => "numeric|required",
			"descricao" => "required|string|max:1000",
			"tipo_documento" => [
				"nullable",
				new EnumRule(TipoDocumento::class)
			],
			"tipo" => [
				"required",
				new EnumRule(TipoLancamento::class)
			],
			"situacao_lancamento" => [
				new EnumRule(SituacaoLancamento::class)
			],
			"modulo" => [
				"required",
				new EnumRule(Modulo::class)
			],
			"cliente_id" => "nullable|exists:clientes,id",
			"fornecedor_id" => "nullable|exists:fornecedores,id",
			"parent_id" => "nullable|exists:lancamento_financeiros,id",
			"plano_conta_id" => "nullable|exists:plano_contas,id",
			"centro_custo_id" => "nullable|exists:centro_custos,id",
			"conta_financeiro_id" => "required|exists:conta_financeiros,id",
			"taxa_correcao_monetaria" => "numeric",
			"taxa_juros"  => "numeric",
			"taxa_multa" => "numeric",
			"num_parcela" => "integer",
			"saldo" => "numeric",
			"valor_correcao_monetaria" => "numeric",
			"valor_desconto" => "numeric",
			"valor_juros" => "numeric",
			"valor_multa" => "numeric",
			"valor_outros" => "numeric",
			"valor_taxa_bancaria" => "numeric",
			"data_arq_remessa" => 'date_format:"Y-m-d"',
			"data_vencimento" => 'required|date_format:"Y-m-d"',
			"data_baixa" => 'date_format:"Y-m-d"',
			"data_conciliacao" => 'date_format:"Y-m-d"',
			"data_efetivacao" => 'date_format:"Y-m-d"',
			"data_emissao" => 'date_format:"Y-m-d"',
			"data_ult_cobranca" => 'date_format:"Y-m-d"',
			"protocolar" =>'boolean',
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
			"parent_id",
			"filial_id",
			"plano_conta_id",
			"centro_custo_id",
			"conta_financeiro_id",
			"cliente_id",
			"fornecedor_id",
			"usuario_id",
			"tipo_documento",
			"data_arq_remessa",
			"data_baixa",
			"data_conciliacao",
			"data_efetivacao",
			"data_emissao",
			"data_ult_cobranca",
			"data_vencimento",
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
            'data_vencimento_renegociacao',
            'data_pagamento',

		];
	}
}
