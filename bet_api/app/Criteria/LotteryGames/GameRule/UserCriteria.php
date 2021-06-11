<?php

namespace App\Criteria\LotteryGames\GameRule;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameRule;
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
        
        /* Don't show status false */
        $model = $model->where('status', '1');

        /* list sort */
        $model = $model->orderBy('sort', 'asc');

        return $model;
    }
}
