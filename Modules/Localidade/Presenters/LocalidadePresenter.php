<?php

namespace Modules\Localidade\Presenters;

use Modules\Localidade\Transformers\LocalidadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LocalidadePresenter
 *
 * @package namespace App\Presenters;
 */
class LocalidadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LocalidadeTransformer();
    }

}
