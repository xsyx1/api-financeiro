<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\LancamentoFinanceiro;
use App\Repositories\BaseRepository;
use Modules\Financeiro\Presenters\ContasPagarPresenter;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ContasPagarRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class ContasPagarRepositoryEloquent extends BaseRepository implements ContasPagarRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return LancamentoFinanceiro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        parent::boot();
    }

    public function presenter()
	{
		return ContasPagarPresenter::class;
	}

	public function bloquear($id)
	{
		$lancamento = $this->skipPresenter(true)->find($id);
		$lancamento->bloqueado = LancamentoFinanceiro::BLOQUEADO;
		return $lancamento->save();
	}
}
