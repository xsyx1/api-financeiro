<?php


namespace Modules\Localidade\Repositories;


use Modules\Localidade\Models\OperadoraTelefonica;
use Modules\Localidade\Presenters\OperadoraTelefonicaPresenter;
use Modules\Localidade\Repositories\OperadoraTelefonicaRepository;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GrupoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OperadoraTelefonicaRepositoryEloquent extends BaseRepository implements OperadoraTelefonicaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperadoraTelefonica::class;
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
		return OperadoraTelefonicaPresenter::class;
	}
}