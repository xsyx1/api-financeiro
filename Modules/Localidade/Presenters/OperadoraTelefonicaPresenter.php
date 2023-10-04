<?php


namespace Modules\Localidade\Presenters;




use Modules\Localidade\Transformers\OperadoraTelefonicaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperadoraTelefonicaPresenter
 *
 * @package namespace ;
 */
class OperadoraTelefonicaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperadoraTelefonicaTransformer();
    }
}