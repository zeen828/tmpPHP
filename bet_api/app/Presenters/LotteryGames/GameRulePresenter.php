<?php

namespace App\Presenters\LotteryGames;

use App\Transformers\LotteryGames\GameRuleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GameRulePresenter.
 *
 * @package namespace App\Presenters\LotteryGames;
 */
class GameRulePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GameRuleTransformer();
    }
}
