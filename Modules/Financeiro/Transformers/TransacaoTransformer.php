<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Models\Transacao;

/**
 * Class TransacaoTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class TransacaoTransformer extends TransformerAbstract
{

	/**
	 * Transform the TransacaoTransformer entity
	 * @param  Transacao $model
	 *
	 * @return  array
	 */
	public function transform(Transacao $model)
	{
		return [
			'id' => (int)$model->id,
		];
	}
}
