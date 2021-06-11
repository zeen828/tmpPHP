<?php

namespace App\Presenters\Trade;

use App\Transformers\Trade\CurrencyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CurrencyPresenter.
 *
 * @package namespace App\Presenters\Trade;
 */
class CurrencyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CurrencyTransformer();
    }
}
