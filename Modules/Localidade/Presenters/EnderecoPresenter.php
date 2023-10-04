<?php

namespace Modules\Localidade\Presenters;

use Modules\Localidade\Transformers\EnderecoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EnderecoPresenter
 *
 * @package namespace Modules\Localidade\Presenters;
 */
class EnderecoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EnderecoTransformer();
    }
}
