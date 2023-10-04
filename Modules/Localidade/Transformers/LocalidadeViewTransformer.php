<?php

namespace Modules\Localidade\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\LocalidadeView;

/**
 * Class LocalidadeViewTransformer
 * @package namespace App\Transformers;
 */
class LocalidadeViewTransformer extends TransformerAbstract
{

    /**
     * Transform the \LocalidadeView entity
     * @param \LocalidadeView $model
     *
     * @return array
     */
    public function transform(LocalidadeView $model)
    {
        return [
            'id'         => (int) $model->id,
            'estado_id'         => (int) $model->estado_id,
            'enderecotable_id'         => (int) $model->enderecotable_id,
            'titulo'         => (string) $model->titulo,
            'titulo_bairro'         => (string) $model->titulo_bairro,
            'uf'         => (string) $model->uf,
            'endereco'         => (string) $model->endereco,
        ];
    }
}
