<?php

namespace Modules\Localidade\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Telefone;

/**
 * Class TelefoneTransformer
 * @package namespace Modules\Localidade\Transformers;
 */
class TelefoneTransformer extends TransformerAbstract
{

	/**
	 * Transform the Telefone entity
	 * @param Telefone $model
	 *
	 * @return array
	 */
	public function transform(Telefone $model)
	{
		return [
			'id' => (int)$model->id,
			'pessoa_id' => (int)$model->pessoa_id,
			'ddd' => (string)$model->ddd,
			'numero' => (string)$model->numero,
			'observacao' => (string)$model->observacao,
			'tipo_telefone' => $model->tipo_telefone,
			'tipo_telefone_enum' => $model->tipo_telefone(),
		];
	}
}
