<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Models\CupomDesconto;

/**
 * Class CupomDescontoTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class CupomDescontoTransformer extends TransformerAbstract
{
	protected array $availableIncludes =[];
	/**
	 * Transform the CupomDescontoTransformer entity
	 * @param  CupomDesconto $model
	 *
	 * @return  array
	 */
	public function transform(CupomDesconto $model)
	{
		return [
			'id' => (int) $model->id,
			'nome' => (string) $model->nome,
			'codigo' => (string) $model->codigo,
			'status' => (int) $model->status,
			'valor' => (double) $model->valor,
			'tipo' => (int)$model->tipo,
		];
	}
}
