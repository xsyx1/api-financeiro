<?php


namespace Modules\Localidade\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Cidade;

/**
 * Class CidadeTransformer
 * @package namespace ;
 */
class CidadeTransformer extends TransformerAbstract
{

	protected $availableIncludes = ['estado'];

    /**
     * Transform the Cidade entity
     * @param Cidade $model
     *
     * @return array
     */
    public function transform(Cidade $model)
    {
        return [
            'id'         => (int) $model->id,
			'estado_id'=> (int) $model->estado_id,
			'cod_cidade'=> (string) $model->cod_cidade,
			'nome'=> (string) $model->nome,
			'capital'=> (boolean) $model->capital,
        ];
    }


	public function includeEstado(Cidade $model)
	{
		if (is_null($model->estado)) {
			return null;
		}
		return $this->item($model->estado, new EstadoTransformer());
	}
}
