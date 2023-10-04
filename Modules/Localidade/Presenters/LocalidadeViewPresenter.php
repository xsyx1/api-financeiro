<?php

namespace Modules\Localidade\Presenters;

use Modules\Localidade\Transformers\LocalidadeViewTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LocalidadeViewPresenter
 *
 * @package namespace App\Presenters;
 */
class LocalidadeViewPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LocalidadeViewTransformer();
    }

}
