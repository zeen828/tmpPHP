<?php

namespace App\Presenters\Trade;

use App\Transformers\Trade\OperateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperatePresenter.
 *
 * @package namespace App\Presenters\Trade;
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
