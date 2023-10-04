<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\CentroCusto;
use Modules\Financeiro\Presenters\CentroCustoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CentroCustoRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class CentroCustoRepositoryEloquent extends BaseRepository implements CentroCustoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return CentroCusto::class;
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
		return CentroCustoPresenter::class;
	}
}