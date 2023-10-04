<?php


namespace Modules\Localidade\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\OperadoraTelefonica;

/**
 * Class OperadoraTransformer
 * @package namespace ;
 */
class OperadoraTelefonicaTransformer extends TransformerAbstract
{


	/**
	 * Transform the Operadora entity
	 * @param OperadoraTelefonica $model
	 *
	 * @return array
	 */
	public function transform(OperadoraTelefonica $model)
	{
		return [
			'id' => (int)$model->id,
			'nome' => (string)$model->nome,
			'codigo' => (string)$model->codigo,
			'id_tb_emitente' => (int)$model->id_tb_emitente,
		];
	}
}
