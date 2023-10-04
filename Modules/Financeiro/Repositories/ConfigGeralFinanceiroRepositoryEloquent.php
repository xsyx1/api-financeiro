<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\ConfigGeralFinanceiro;
use Modules\Financeiro\Presenters\ConfigGeralFinanceiroPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ConfigGeralFinanceiroRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class ConfigGeralFinanceiroRepositoryEloquent extends BaseRepository implements ConfigGeralFinanceiroRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return ConfigGeralFinanceiro::class;
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
		return ConfigGeralFinanceiroPresenter::class;
	}
}