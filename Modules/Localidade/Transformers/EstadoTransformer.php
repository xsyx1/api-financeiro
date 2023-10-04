<?php


namespace Modules\Localidade\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Estado;

/**
 * Class EstadoTransformer
 * @package namespace ;
 */
class EstadoTransformer extends TransformerAbstract
{

	protected $availableIncludes = ["pais"];

    /**
     * Transform the Estado entity
     * @param Estado $model
     *
     * @return array
     */
    public function transform(Estado $model)
    {
        return [
            'id'         => (int) $model->id,
			'nome'=> (string) $model->nome,
			'uf'=> (string) $model->uf,
            'cod_ibje'=> $model->cod_ibje,
        ];
    }

	public function includePais(Estado $model)
	{
		if (is_null($model->pais)) {
			return null;
		}
		return $this->item($model->pais, new PaisTransformer());
	}
}
