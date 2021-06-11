<?php

namespace App\Criteria\LotteryGames\GameDraw;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon;

/**
 * Class UserCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameDraw;
 */
class UserCriteria implements CriteriaInterface
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
        
        /* Don't show the ones that have not expired */
        $nowUAt = Carbon::now();
        $model = $model->where('draw_at', '<=', $nowUAt);

        /* Don't show not draw number */
        $model = $model->whereNotNull('general_draw');

        /* Don't show status false */
        $model = $model->where('status', '1');

        return $model;
    }
}
