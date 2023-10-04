<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\PlanoConta;
use Modules\Financeiro\Presenters\PlanoContaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PlanoContaRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class PlanoContaRepositoryEloquent extends BaseRepository implements PlanoContaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return PlanoConta::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
	{
		return PlanoContaPresenter::class;
	}
}