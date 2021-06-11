<?php

namespace App\Presenters\Member;

use App\Transformers\Member\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace App\Presenters\Member;
 */
class UserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }
}
