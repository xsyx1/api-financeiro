<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Models\ConfigGeralFinanceiro;

/**
 * Class ConfigGeralFinanceiroTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class ConfigGeralFinanceiroTransformer extends TransformerAbstract
{

	/**
	 * Transform the ConfigGeralFinanceiroTransformer entity
	 * @param  ConfigGeralFinanceiro $model
	 *
	 * @return  array
	 */
	public function transform(ConfigGeralFinanceiro $model)
	{
		return array_remove_null([
			'id' => (int)$model->id,
			'data_base' => $model->data_base,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at,
		]);
	}
}
