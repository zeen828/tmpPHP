<?php

namespace App\Presenters\LotteryGames;

use App\Transformers\LotteryGames\GameRuleTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GameRuleTypePresenter.
 *
 * @package namespace App\Presenters\LotteryGames;
 */
class GameRuleTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GameRuleTypeTransformer();
    }
}
