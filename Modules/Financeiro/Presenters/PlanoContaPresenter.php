<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\PlanoContaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanoContaPresenter
 *
 * @package  namespace ;
 */
class PlanoContaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanoContaTransformer();
    }
}
