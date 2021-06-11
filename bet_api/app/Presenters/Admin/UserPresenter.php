<?php

namespace App\Presenters\Admin;

use App\Transformers\Admin\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace App\Presenters\Admin;
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
