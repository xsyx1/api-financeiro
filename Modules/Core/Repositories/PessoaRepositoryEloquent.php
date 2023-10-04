<?php

namespace Modules\Core\Repositories;

use Modules\Core\Presenters\PessoaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Models\Pessoa;
use Modules\Core\Validators\PessoaValidator;

/**
 * Class PessoaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PessoaRepositoryEloquent extends BaseRepository implements PessoaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pessoa::class;
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
		return PessoaPresenter::class;
	}
}
