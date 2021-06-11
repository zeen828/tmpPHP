<?php

namespace App\Presenters\Receipt;

use App\Transformers\Receipt\OperateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperatePresenter.
 *
 * @package namespace App\Presenters\Receipt;
 */
class OperatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperateTransformer();
    }
}
