<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Presenters\EstadoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Models\Estado;
use Modules\Localidade\Validators\EstadoValidator;

/**
 * Class EstadoRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class EstadoRepositoryEloquent extends BaseRepository implements EstadoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Estado::class;
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
		return EstadoPresenter::class;
	}
}
