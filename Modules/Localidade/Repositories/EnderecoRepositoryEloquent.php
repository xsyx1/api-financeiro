<?php

namespace Modules\Localidade\Repositories;

use Modules\Localidade\Presenters\EnderecoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\EnderecoRepository;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Validators\EnderecoValidator;

/**
 * Class EnderecoRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class EnderecoRepositoryEloquent extends BaseRepository implements EnderecoRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Endereco::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
		parent::boot();
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
        return EnderecoPresenter::class;
    }
}
