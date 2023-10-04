<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\Filial;
use Modules\Core\Presenters\FilialPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GrupoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FilialRepositoryEloquent extends BaseRepository implements FilialRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Filial::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    	parent::boot();
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
	{
		return FilialPresenter::class;
	}
}
