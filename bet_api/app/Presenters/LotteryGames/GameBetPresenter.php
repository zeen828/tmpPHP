<?php

namespace App\Presenters\LotteryGames;

use App\Transformers\LotteryGames\GameBetTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GameBetPresenter.
 *
 * @package namespace App\Presenters\LotteryGames;
 */
class GameBetPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GameBetTransformer();
    }
}
