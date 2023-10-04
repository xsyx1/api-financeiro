<?php


namespace Modules\Localidade\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Bairro;

/**
 * Class BairroTransformer
 * @package namespace ;
 */
class BairroTransformer extends TransformerAbstract
{
	protected $availableIncludes = ['cidade'];

	/**
	 * Transform the Bairro entity
	 * @param Bairro $model
	 *
	 * @return array
	 */
	public function transform(Bairro $model)
	{
		return [
			'id' => (int)$model->id,
			'cidade_id' => (int)$model->cidade_id,
			'nome' => (string)$model->nome,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at,
		];
	}

	public function includeCidade(Bairro $model)
	{
		if (is_null($model->cidade)) {
			return null;
		}
		return $this->item($model->cidade, new CidadeTransformer());
	}
}
