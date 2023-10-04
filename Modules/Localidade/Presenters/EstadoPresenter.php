<?php


namespace Modules\Localidade\Presenters;




use Modules\Localidade\Transformers\EstadoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EstadoPresenter
 *
 * @package namespace ;
 */
class EstadoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EstadoTransformer();
    }
}