<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Core\Enuns\Modulo;
use Modules\Financeiro\Enuns\SituacaoLancamento;
use Modules\Financeiro\Enuns\TipoDocumento;
use Modules\Financeiro\Enuns\TipoLancamento;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class ContasPagarRequest extends BaseRequest implements ICustomRequest
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
			"cliente_id" => "required|exists:clientes,id",
			"fornecedor_id" => "nullable|exists:fornecedores,id",
			"parent_id" => "nullable|exists:lancamento_financeiros,id",
			"plano_conta_id" => "nullable|exists:plano_contas,id",
			"centro_custo_id" => "nullable|exists:centro_custos,id",
			"conta_financeiro_id" => "nullable|exists:conta_financeiros,id",
			"taxa_correcao_monetaria" => "nullable",
			"taxa_juros"  => "nullable",
			"taxa_multa" => "nullable",
			"num_parcela" => "integer",
			"saldo" => "nullable",
			"valor_correcao_monetaria" => "nullable",
			"valor_desconto" => "nullable",
			"valor_juros" => "nullable",
			"valor_multa" => "nullable",
			"valor_outros" => "nullable",
			"valor_taxa_bancaria" => "nullable",
			"data_vencimento" => 'required',
			"protocolar" => 'boolean',
			"recorrente" => 'boolean'
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
			"centro_custo",
			"conta_financeiro_id",
			"cliente_id",
			"usuario_id",
			"venda_id",
			"tipo_documento",
			"data_arq_remessa",
			"data_baixa",
			"data_conciliacao",
			"data_efetivacao",
			"data_emissao",
			"data_ult_cobranca",
			"data_competencia",
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
			'intervalo',
			'parcelas',
		];
	}

	public function messages()
	{
		return [
			'modulo.required' => 'Modulo não informado',
			'cliente_id.exists' => 'Cliente não encontrado!',
			'plano_conta_id.exists' => 'Plano de contas não encontrado!',
			'centro_custo_id.exists' => 'Centro de custo não encontrado!',
			'agrupados.*.exists' => 'Lançamento financeiro não encontrado!',
			'conta_financeiro_id.exists' => 'Conta financeira não encontrada!',
			'tipo.required' => 'Tipo de lançamento não informado!',
			'descricao.required' => 'A descrição da baixa não foi informada',
			'descricao.max:1000' => 'O tamanho máximo da descrição é de 1000 caracteres!'
		];
	}
}
