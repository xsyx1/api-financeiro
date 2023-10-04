<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Models\InformacaoBancaria;

/**
 * Class InformacaoBancariaTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class InformacaoBancariaTransformer extends TransformerAbstract
{

	/**
	 * Transform the InformacaoBancariaTransformer entity
	 * @param  InformacaoBancaria $model
	 *
	 * @return  array
	 */
	public function transform(InformacaoBancaria $model)
	{
		return [
			'id' => (int)$model->id,
			"variacao" => (int)$model->variacao,
			"nome_gerente" => (string)$model->nome_gerente,
			"titular" => (string)$model->titular,
			"telefone_contato" => (string)$model->telefone_contato,
			"descricao" => (string)$model->descricao,
            "pessoa_id" => (int)$model->pessoa_id,
            "digito_agencia" => $model->digito_agencia,
            "digito_conta" => $model->digito_conta,
			"banco" => (string)$model->banco,
			"conta" => (string)$model->conta,
			"agencia" => (string)$model->agencia,
			"numero_cartao" => (string)$model->numero_cartao,
			"conta_financeiro_id" => (int)$model->conta_financeiro_id,
		];
	}
}
