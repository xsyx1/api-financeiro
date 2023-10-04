<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    protected function removeNull(array $itens)
    {
        return array_remove_null($itens);
    }
}
