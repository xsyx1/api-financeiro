<?php

namespace Modules\Financeiro\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CentroCustoCriteria
 * @package  Modules\Financeiro\Criteria;
 */
class CentroCustoCriteria extends BaseCriteria
{
	protected $filterCriteria = [
		'financeiro.centro_custos.nome' => 'ilike',
		'financeiro.centro_custos.tipo' => '=',
		'financeiro.centro_custos.status' => '=',
		'financeiro.centro_custos.codigo' => '=',
	];

	public function apply($model, RepositoryInterface $repository)
	{
		$model = parent::apply($model, $repository);
		return $model;
	}

}
