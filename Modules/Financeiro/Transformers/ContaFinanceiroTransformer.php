<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Models\ContaFinanceiro;

/**
 * Class ContaFinanceiroTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class ContaFinanceiroTransformer extends TransformerAbstract
{
	protected array $availableIncludes = ['informacao_bancaria'];

	/**
	 * Transform the ContaFinanceiroTransformer entity
	 * @param  ContaFinanceiro $model
	 *
	 * @return  array
	 */
	public function transform(ContaFinanceiro $model)
	{
		return [
			'id' => (int)$model->id,
			"tipo_conta" => (string)$model->tipo_conta,
            "permitir_lanc_data_superior" => (boolean)$model->permitir_lanc_data_superior,
            "permitir_lanc_data_anterior" => (boolean)$model->permitir_lanc_data_anterior,
            "descricao" => (string)$model->descricao,
            "telefone_contato" => (string)$model->telefone_contato,
			"status" => (int)$model->status,
			"nome" => (string)$model->nome,
			"saldo" => (double)$model->saldo,
			"dashboard" => (boolean)$model->dashboard,
			"emite_boleto" => (boolean)$model->emite_boleto,
			"limite" => (int)$model->limite
		];
	}


	public function includeInformacaoBancaria(ContaFinanceiro $model)
	{
		if (is_null($model->informacao_bancaria)) {
			return $this->null();
		}
		return $this->item($model->informacao_bancaria, new InformacaoBancariaTransformer());
	}

}
