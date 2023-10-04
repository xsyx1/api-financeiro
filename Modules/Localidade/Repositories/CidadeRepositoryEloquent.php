<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Presenters\CidadePresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Models\Cidade;

/**
 * Class CidadeRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class CidadeRepositoryEloquent extends BaseRepository implements CidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cidade::class;
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
		return CidadePresenter::class;
	}
}
