<?php

namespace Modules\Localidade\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ClientCriteria
 * @package namespace App\Criteria;
 */
class LocalidadeViewCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [];

    protected $filterCriteriaOr = [
        [
            'elements'=>[
                '_localidades.titulo',
                '_localidades.titulo_bairro',
                '_localidades.endereco',
            ],
            'condition'=>'ilike'
        ]
    ];
}
