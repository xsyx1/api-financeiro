<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\ContasPagarTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LancamentoFinanceiroPresenter
 *
 * @package  namespace ;
 */
class ContasPagarPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContasPagarTransformer();
    }
}
