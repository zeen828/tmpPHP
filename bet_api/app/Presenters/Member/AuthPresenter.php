<?php

namespace App\Presenters\Member;

use App\Transformers\Member\AuthTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AuthPresenter.
 *
 * @package namespace App\Presenters\Member;
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
