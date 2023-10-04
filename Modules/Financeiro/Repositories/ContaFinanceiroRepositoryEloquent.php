<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\ContaFinanceiro;
use Modules\Financeiro\Presenters\ContaFinanceiroPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ContaFinanceiroRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class ContaFinanceiroRepositoryEloquent extends BaseRepository implements ContaFinanceiroRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return ContaFinanceiro::class;
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
		return ContaFinanceiroPresenter::class;
	}
}