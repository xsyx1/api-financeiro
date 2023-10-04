<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Models\Localidade;
use Modules\Localidade\Presenters\LocalidadePresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class LocalidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LocalidadeRepositoryEloquent extends BaseRepository implements LocalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Localidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function pesquisarByCep($cep)
    {
        $cep = $this->model->where('cep','=',$cep)->orderBy('id','desc')->first();
        if(!is_null($cep)){
            return $this->parserResult($cep);
        }
        return $cep;
    }

    public function presenter()
    {
        return LocalidadePresenter::class;
    }
}
