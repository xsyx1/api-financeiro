<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\TransacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransacaoPresenter
 *
 * @package  namespace ;
 */
class TransacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransacaoTransformer();
    }
}
