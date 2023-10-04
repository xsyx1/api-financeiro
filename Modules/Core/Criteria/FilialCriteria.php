<?php


namespace Modules\Core\Criteria;



use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilialCriteria
 * @package namespace ;
 */
class FilialCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
		'core.pessoas.nome' => 'ilike',
		'core.pessoas.email' => 'ilike',
		'core.pessoas.razao_social' => 'ilike',
		'core.pessoas.cpf_cnpj' => 'ilike',
	];

	public function apply($model, RepositoryInterface $repository)
	{
		$model = parent::apply($model, $repository);
		return $model->leftjoin('core.pessoas','core.filiais.pessoa_id', '=', 'core.pessoas.id')
			->select('filiais.*');
	}


}
