<?php


namespace Modules\Localidade\Presenters;




use Modules\Localidade\Transformers\BairroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BairroPresenter
 *
 * @package namespace ;
 */
class BairroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BairroTransformer();
    }
}