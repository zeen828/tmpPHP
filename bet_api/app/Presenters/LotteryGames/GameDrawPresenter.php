<?php

namespace App\Presenters\LotteryGames;

use App\Transformers\LotteryGames\GameDrawTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GameDrawPresenter.
 *
 * @package namespace App\Presenters\LotteryGames;
 */
class GameDrawPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GameDrawTransformer();
    }
}
