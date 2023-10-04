<?php

namespace Modules\Core\Presenters;

use Modules\Core\Transformers\FilialTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FilialPresenter
 *
 * @package namespace ;
 */
class FilialPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FilialTransformer();
    }
}