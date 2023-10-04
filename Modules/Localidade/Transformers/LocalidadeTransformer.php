<?php

namespace Modules\Localidade\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Localidade;

/**
 * Class LocalidadeTransformer
 * @package namespace App\Transformers;
 */
class LocalidadeTransformer extends TransformerAbstract
{

    /**
     * Transform the \Localidade entity
     * @param \Modules\Localidade\Models\Localidade $model
     *
     * @return array
     */
    public function transform(Localidade $model)
    {
        return [
            'id' => (int) $model->id,
            'cep' => (string) $model->cep,
            'logradouro' => (string) $model->logradouro,
            'cidade_id' => (int) $model->cidade_id,
            'cidade_titulo' => (string) (is_null($model->cidade))?null:$model->cidade->titulo,
            'estado_id' => (int) $model->estado_id,
            'estado_titulo' => (string) (is_null($model->estado))?null:$model->estado->titulo,
            'estado_uf' => (string) (is_null($model->estado))?null:$model->estado->uf,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

}
