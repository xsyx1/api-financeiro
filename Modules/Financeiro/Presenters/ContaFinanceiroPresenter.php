<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\ContaFinanceiroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContaFinanceiroPresenter
 *
 * @package  namespace ;
 */
class ContaFinanceiroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContaFinanceiroTransformer();
    }
}
