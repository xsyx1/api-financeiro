<?php


namespace Modules\Financeiro\Presenters;

use Modules\Financeiro\Transformers\ConfigGeralFinanceiroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ConfigGeralFinanceiroPresenter
 *
 * @package  namespace ;
 */
class ConfigGeralFinanceiroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ConfigGeralFinanceiroTransformer();
    }
}
