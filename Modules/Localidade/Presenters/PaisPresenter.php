<?php


namespace Modules\Localidade\Presenters;




use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PaisPresenter
 *
 * @package namespace ;
 */
class PaisPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PaisTransformer();
    }
}