<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\InformacaoBancaria;
use Modules\Financeiro\Presenters\InformacaoBancariaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class InformacaoBancariaRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class InformacaoBancariaRepositoryEloquent extends BaseRepository implements InformacaoBancariaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return InformacaoBancaria::class;
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
		return InformacaoBancariaPresenter::class;
	}
}