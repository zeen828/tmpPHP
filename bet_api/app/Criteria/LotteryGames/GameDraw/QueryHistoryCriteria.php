<?php

namespace App\Criteria\LotteryGames\GameDraw;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon;

/**
 * Class QueryHistoryCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameDraw;
 */
class QueryHistoryCriteria implements CriteriaInterface
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
        $timeZone  = request()->header('x-timezone')? request()->header('x-timezone') : 'UTC';

        /* draw period */
        $period = request()->input('period');
        if (!empty($period)) {
            $model = $model->where('period', $period);
        }

        /* open draw date */
        /* get date */
        $startDay = request()->input('start');
        if (!empty($startDay)) {
            $startAtStr = sprintf('%s 00:00:00', $startDay);
            $startUAt = Carbon::parse($startAtStr, $timeZone)->setTimezone('UTC');
            $model = $model->where('draw_at', '>=', $startUAt);
        }
        $endDay = request()->input('end');
        if (!empty($endDay)) {
            $endAtStr = sprintf('%s 23:59:59', $endDay);
            $endUAt = Carbon::parse($endAtStr, $timeZone)->setTimezone('UTC');
            $model = $model->where('draw_at', '<=', $endUAt);
        }

        /* data list sort */
        $model = $model->orderBy('draw_at', 'desc');

        return $model;
    }
}
