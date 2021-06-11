<?php

namespace App\Presenters\LotteryGames;

use App\Transformers\LotteryGames\GameSettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GameSettingPresenter.
 *
 * @package namespace App\Presenters\LotteryGames;
 */
class GameSettingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GameSettingTransformer();
    }
}
