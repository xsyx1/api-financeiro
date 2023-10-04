<?php


namespace Modules\Localidade\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Pais;

/**
 * Class PaisTransformer
 * @package namespace ;
 */
class PaisTransformer extends TransformerAbstract
{


	/**
	 * Transform the Pais entity
	 * @param Pais $model
	 *
	 * @return array
	 */
	public function transform(Pais $model)
	{
		return [
			'id' => (int)$model->id,
			'nome' => (string)$model->nome,
			'sigla' => (string)$model->sigla,
			'nacionalidade' => (string)$model->nacionalidade,
		];
	}
}
