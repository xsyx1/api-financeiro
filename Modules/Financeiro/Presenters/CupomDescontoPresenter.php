<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\CupomDescontoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CupomDescontoPresenter
 *
 * @package  namespace ;
 */
class CupomDescontoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CupomDescontoTransformer();
    }
}
