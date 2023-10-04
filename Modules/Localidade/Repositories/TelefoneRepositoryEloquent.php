<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Presenters\TelefonePresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\TelefoneRepository;
use Modules\Localidade\Models\Telefone;
use Modules\Localidade\Validators\TelefoneValidator;

/**
 * Class TelefoneRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class TelefoneRepositoryEloquent extends BaseRepository implements TelefoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Telefone::class;
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
        return TelefonePresenter::class;
    }
}
