<?php

namespace App\Criteria\LotteryGames\GameDraw;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon;

/**
 * Class JobGameRewardCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameDraw;
 */
class JobGameRewardCriteria implements CriteriaInterface
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
        /* Don't show the ones that have not expired */
        $nowUAt = Carbon::now();
        $model = $model->where('draw_at', '<=', $nowUAt);

        /* Don't show not draw number */
        $model = $model->whereNotNull('general_draw');

        $model = $model->where('redeem', '0');

        /* Don't show status false */
        $model = $model->where('status', '1');

        return $model;
    }
}
