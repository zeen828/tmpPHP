<?php

namespace App\Criteria\LotteryGames\GameDraw;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AdminCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameDraw;
 */
class AdminCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param object              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /* route game id */
        $gameId = request()->route('gameId');
        $model = $model->where('game_id', $gameId);

        return $model;
    }
}
