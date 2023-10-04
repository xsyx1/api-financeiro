<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\FilialTransformer;
use Modules\Core\Transformers\UserTransformer;
use Modules\Financeiro\Models\LancamentoFinanceiro;

/**
 * Class LancamentoFinanceiroTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class LancamentoFinanceiroTransformer extends TransformerAbstract
{

	protected array $availableIncludes = [
		'pai',
		'filhos',
		'plano_conta',
		'centro_custo',
		'conta_financeiro',
		'filial',
		'cliente',
		'usuario',
	];

	/**
	 * Transform the LancamentoFinanceiroTransformer entity
	 * @param  LancamentoFinanceiro $model
	 *
	 * @return  array
	 */
	public function transform(LancamentoFinanceiro $model)
	{
		return [
			"id" => $model->id,
			"parent_id" => $model->parent_id,
			"filial_id" => $model->filial_id,
			"cliente_id" => $model->cliente_id,
			"conta_financeiro_id" => $model->conta_financeiro_id,
			"usuario_id" => $model->usuario_id,
			"plano_conta_id" => $model->plano_conta_id,
			"data_arq_remessa" => $model->data_arq_remessa,
			"data_baixa" => $model->data_baixa,
			"data_conciliacao" => $model->data_conciliacao,
			"data_efetivacao" => $model->data_efetivacao,
			"data_emissao" => $model->data_emissao,
			"data_ult_cobranca" => $model->data_ult_cobranca,
			"data_vencimento" => $model->data_vencimento,
			'descricao' => $model->descricao,
			"tipo_enum" => $model->tipo_enum(),
			"num_parcela" => $model->num_parcela,
			"modulo_enum" => $model->modulo_enum(),
			"protocolar" => $model->protocolar,
			"qtd_dias_carencia_juros" => $model->qtd_dias_carencia_juros,
			"qtd_dias_carencia_multa" => $model->qtd_dias_carencia_multa,
			"recorrente" => $model->recorrente,
			"situacao_lancamento" => $model->situacao_lancamento,
			"situacao_lancamento_enum" => $model->situacao_lancamento_enum(),
			"taxa_correcao_monetaria" => $model->taxa_correcao_monetaria,
			"taxa_juros" => $model->taxa_juros,
			"taxa_multa" => $model->taxa_multa,
			"valor_original" => $model->valor_original,
			"saldo" => $model->saldo,
			"valor_correcao_monetaria" => $model->valor_correcao_monetaria,
			"valor_desconto" => $model->valor_desconto,
			"valor_juros" => $model->valor_juros,
			"valor_multa" => $model->valor_multa,
			"valor_outros" => $model->valor_outros,
			"valor_taxa_bancaria" => $model->valor_taxa_bancaria,
			'descricao_caixa' => $model->descricao_caixa,
			'historico' => $model->historico,
			'numero_documento' => $model->numero_documento,
			'status_lancamento' => $model->status_lancamento,
			"status_lancamento_enum" => $model->status_enum(),
			'situacao_pagamento' => $model->situacao_pagamento,
			"situacao_pagamento_enum" => $model->situacao_pagamento_enum(),
			'tipo_parcela' => $model->tipo_parcela,
			"tipo_parcela_enum" => $model->tipo_parcela_enum(),
			'historico_situacao' => $model->historico_situacao,
			"historico_situacao_enum" => $model->historico_situacao_enum(),
			'situacao_contrato' => $model->situacao_contrato,
			"situacao_contrato_enum" => $model->situacao_contrato_enum(),
			'origem_lancamento' => $model->origem_lancamento,
			'data_vencimento_renegociacao' => $model->data_vencimento_renegociacao,
			'data_pagamento' => $model->data_pagamento,
			"valor_pago" => $model->valor_pago,
			"total_parcelas" => $model->total_parcelas,
			"tipo_documento" => $model->tipo_documento,
			"tipo_documento_enum" => $model->tipo_documento_enum(),
			"venda_id" => $model->venda_id,
			"tipo_venda" => $model->tipo_venda,
			"data_credito" => $model->data_credito,
			"data_competencia" => $model->data_competencia,
			"data_prorrogada" => $model->data_prorrogada,
			"usuario_desconto" => $model->usuario_desconto
		];
	}

	public function includePai(LancamentoFinanceiro $model)
	{
		if (is_null($model->pai)) {
			return $this->null();
		}
		return $this->item($model->pai, new LancamentoFinanceiroTransformer());
	}

	public function includePlanoConta(LancamentoFinanceiro $model)
	{
		if (is_null($model->plano_conta)) {
			return $this->null();
		}
		return $this->item($model->plano_conta, new PlanoContaTransformer());
	}

	public function includeCentroCusto(LancamentoFinanceiro $model)
	{
		if ($model->centro_pivot->count() == 0) {
			return $this->null();
		}
		return $this->collection($model->centro_pivot, new CentroCustoTransformer());
	}

	public function includeContaFinanceiro(LancamentoFinanceiro $model)
	{
		if (is_null($model->conta_financeiro)) {
			return $this->null();
		}
		return $this->item($model->conta_financeiro, new ContaFinanceiroTransformer());
	}

	public function includeFilial(LancamentoFinanceiro $model)
	{
		if (is_null($model->filial)) {
			return $this->null();
		}
		return $this->item($model->filial, new FilialTransformer());
	}

	public function includeCliente(LancamentoFinanceiro $model)
	{
		if (is_null($model->cliente)) {
			return $this->null();
		}
		return $this->item($model->cliente, new ClienteTransformer());
	}

	public function includeUsuario(LancamentoFinanceiro $model)
	{
		if (is_null($model->usuario)) {
			return $this->null();
		}
		return $this->item($model->usuario, new UserTransformer());
	}

	public function includeFilhos(LancamentoFinanceiro $model)
	{
		if (is_null($model->filhos)) {
			return null;
		}
		return $this->collection($model->filhos, new ContasReceberTransformer());
	}
}
