<?php


namespace Modules\Financeiro\Repositories;


use Modules\Financeiro\Models\LancamentoFinanceiro;
use Modules\Financeiro\Presenters\LancamentoFinanceiroPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class LancamentoFinanceiroRepositoryEloquent
 * @package  namespace Modules\Financeiro\Repositories;
 */
class LancamentoFinanceiroRepositoryEloquent extends BaseRepository implements LancamentoFinanceiroRepository
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
		return LancamentoFinanceiroPresenter::class;
	}

	public function bloquear($id)
	{
		$lancamento = $this->skipPresenter(true)->find($id);
		$lancamento->bloqueado = LancamentoFinanceiro::BLOQUEADO;
		return $lancamento->save();
	}
}