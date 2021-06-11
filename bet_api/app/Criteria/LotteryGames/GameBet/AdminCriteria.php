<?php

namespace App\Criteria\LotteryGames\GameBet;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use TokenAuth;

/**
 * Class AdminCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameBet;
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
        /* Client source */
        $client = TokenAuth::getClient();
        $model = $model->where('source_type', get_class($client));
        $model = $model->where('source_id', $client->id);

        /* route game id */
        $gameId = request()->route('gameId');
        $model = $model->where('game_id', $gameId);

        /* data list sort */
        $model = $model->orderBy('created_at', 'desc');

        return $model;
    }
}
