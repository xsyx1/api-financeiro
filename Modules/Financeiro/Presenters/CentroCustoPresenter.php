<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\CentroCustoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CentroCustoPresenter
 *
 * @package  namespace ;
 */
class CentroCustoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CentroCustoTransformer();
    }
}
