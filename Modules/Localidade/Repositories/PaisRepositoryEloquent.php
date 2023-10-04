<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Presenters\PaisPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\PaisRepository;
use Modules\Localidade\Models\Pais;
use Modules\Localidade\Validators\PaisValidator;

/**
 * Class PaisRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class PaisRepositoryEloquent extends BaseRepository implements PaisRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pais::class;
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
		return PaisPresenter::class;
	}
}
