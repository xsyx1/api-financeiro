<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\LancamentoFinanceiroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LancamentoFinanceiroPresenter
 *
 * @package  namespace ;
 */
class LancamentoFinanceiroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LancamentoFinanceiroTransformer();
    }
}
