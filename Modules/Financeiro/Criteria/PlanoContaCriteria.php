<?php

namespace Modules\Financeiro\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PlanoContaCriteria
 * @package  Modules\Financeiro\Criteria;
 */
class PlanoContaCriteria extends BaseCriteria
{
    protected $filterCriteria = [
    	'financeiro.plano_contas.nome' => 'ilike',
    	'financeiro.plano_contas.tipo' => '=',
    	'financeiro.plano_contas.status' => '=',
    	'financeiro.plano_contas.codigo' => '=',
    	'financeiro.plano_contas.parent_id' => '=',
	];

	public function apply($model, RepositoryInterface $repository)
	{
		$model = parent::apply($model, $repository);
		return $model->where('parent_id',null);
	}

}