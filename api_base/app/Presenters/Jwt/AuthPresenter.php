<?php

namespace App\Presenters\Jwt;

use App\Transformers\Jwt\AuthTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AuthPresenter.
 *
 * @package namespace App\Presenters\Jwt;
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
