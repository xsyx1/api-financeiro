<?php


namespace Modules\Financeiro\Repositories;

use Modules\Financeiro\Models\CupomDesconto;
use Modules\Financeiro\Presenters\CupomDescontoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CupomDescontoRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class CupomDescontoRepositoryEloquent extends BaseRepository implements  CupomDescontoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return CupomDesconto::class;
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
		return CupomDescontoPresenter::class;
	}
}