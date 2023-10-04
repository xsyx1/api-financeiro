<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Enuns\TipoPlanoConta;
use Modules\Financeiro\Models\CentroCusto;

/**
 * Class CentroCustoTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class CentroCustoTransformer extends TransformerAbstract
{
	/**
	 * Transform the CentroCustoTransformer entity
	 * @param  CentroCusto $model
	 *
	 * @return  array
	 */
	public function transform(CentroCusto $model)
	{
		return [
			'id' => (int)$model->id,
			'nome' => (string)$model->nome,
			'cor' => (string)$model->cor,
			'status' => (bool)$model->status,
			'status_label' => $model->status ? 'Ativo' : 'Inativo',
			'tipo' => (int)$model->tipo,
			'tipo_label' => (new TipoPlanoConta($model->tipo))->toArray(),
			'recebe_lancamento' => (bool)$model->recebe_lancamento,
			'codigo' => (string)$model->codigo,
		];
	}
}
