<?php

namespace Modules\Localidade\Presenters;

use Modules\Localidade\Transformers\TelefoneTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TelefonePresenter
 *
 * @package namespace Modules\Localidade\Presenters;
 */
class TelefonePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TelefoneTransformer();
    }
}
