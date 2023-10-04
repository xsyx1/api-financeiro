<?php

namespace Modules\Financeiro\Criteria;

use App\Criteria\BaseCriteria;

/**
 * Class ContaFinanceiroCriteria
 * @package  Modules\Financeiro\Criteria;
 */
class ContaFinanceiroCriteria extends BaseCriteria
{
    protected $filterCriteria = [
		'financeiro.conta_financeiros.nome' => 'ilike',
		'financeiro.conta_financeiros.id' => '=',
	];
}