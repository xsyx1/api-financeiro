<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Presenters\BairroPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\BairroRepository;
use Modules\Localidade\Models\Bairro;
use Modules\Localidade\Validators\BairroValidator;

/**
 * Class BairroRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class BairroRepositoryEloquent extends BaseRepository implements BairroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bairro::class;
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
		return BairroPresenter::class;
	}
}
