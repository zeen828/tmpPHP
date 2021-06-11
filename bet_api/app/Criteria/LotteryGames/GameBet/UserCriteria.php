<?php

namespace App\Criteria\LotteryGames\GameBet;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use TokenAuth;

/**
 * Class UserCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameBet;
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
        /* User source */
        $user = TokenAuth::getUser();
        $model = $model->where('user_type', get_class($user));
        $model = $model->where('user_id', $user->id);

        /* route game id */
        $gameId = request()->route('gameId');
        $model = $model->where('game_id', $gameId);
        
        /* Don't show status false */
        $model = $model->where('status', '1');

        /* data list sort */
        $model = $model->orderBy('created_at', 'desc');

        return $model;
    }
}
