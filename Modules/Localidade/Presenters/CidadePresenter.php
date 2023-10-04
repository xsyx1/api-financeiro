<?php

namespace Modules\Localidade\Presenters;

use Modules\Localidade\Transformers\CidadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CidadePresenter
 *
 * @package namespace ;
 */
class CidadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CidadeTransformer();
    }
}