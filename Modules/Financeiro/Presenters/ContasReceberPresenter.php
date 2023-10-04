<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\ContasReceberTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LancamentoFinanceiroPresenter
 *
 * @package  namespace ;
 */
class ContasReceberPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContasReceberTransformer();
    }
}
