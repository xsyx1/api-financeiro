<?php

namespace Modules\Core\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserCriteria
 * @package namespace App\Criteria;
 */
class UserCriteria extends BaseCriteria implements CriteriaInterface
{

	protected $filterCriteria = [
		'core.users.id' => '=',
		'core.users.nome' => 'ilike',
		'core.users.email' => 'like',
		'core.users.username' => '=',
		'core.users.status' => '=',
		'core.grupos.id' => 'in',
		'core.users.created_at' => 'between',
	];

	public function apply($model, RepositoryInterface $repository)
	{
		$model = parent::apply($model, $repository);
		return $model
			->leftJoin('core.usuario_grupos', 'core.users.id', '=', 'core.usuario_grupos.user_id')
			->leftJoin('core.grupos', 'core.grupos.id', '=', 'core.usuario_grupos.grupo_id')
			->select('users.*')
			->GroupBy('core.users.id');
	}

}
