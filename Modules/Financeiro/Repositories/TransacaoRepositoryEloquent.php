<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\Transacao;
use Modules\Financeiro\Presenters\TransacaoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class TransacaoRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class TransacaoRepositoryEloquent extends BaseRepository implements TransacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Transacao::class;
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
		return TransacaoPresenter::class;
	}
}