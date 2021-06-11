<?php

namespace App\Presenters\Jwt;

use App\Transformers\Jwt\ClientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientPresenter.
 *
 * @package namespace App\Presenters\Jwt;
 */
class ClientPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientTransformer();
    }
}
