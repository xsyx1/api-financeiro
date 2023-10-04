<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\InformacaoBancariaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class InformacaoBancariaPresenter
 *
 * @package  namespace ;
 */
class InformacaoBancariaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new InformacaoBancariaTransformer();
    }
}
