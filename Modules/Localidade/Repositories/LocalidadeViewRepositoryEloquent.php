<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Models\LocalidadeView;
use Modules\Localidade\Presenters\LocalidadeViewPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Validators\LocalidadeViewValidator;

/**
 * Class LocalidadeViewRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LocalidadeViewRepositoryEloquent extends BaseRepository implements LocalidadeViewRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LocalidadeView::class;
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
        return LocalidadeViewPresenter::class;
    }
}
