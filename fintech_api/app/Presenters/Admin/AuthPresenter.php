<?php

namespace App\Presenters\Admin;

use App\Transformers\Admin\AuthTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AuthPresenter.
 *
 * @package namespace App\Presenters\Admin;
 */
class AuthPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AuthTransformer();
    }
}
