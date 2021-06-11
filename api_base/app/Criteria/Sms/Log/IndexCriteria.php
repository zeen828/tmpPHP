<?php

namespace App\Criteria\Sms\Log;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use SystemParameter;
use Carbon;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\Sms\Log;
 */
class IndexCriteria implements CriteriaInterface
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
        $months = SystemParameter::getValue('sms_query_limit_months');
        /* Limit table */
        $now = Carbon::now();
        /* Preliminary client end detetime */
        $endClient = Carbon::parse($model->asClientTime($now));
        /* Client dete end limit */
        $endLimit = $endClient->format('Y-m-d');
        /* Client dete start limit */
        $startLimit = $endClient->subMonth($months)->format('Y-m-01');
        /* Date range */
        $start = request()->input('start');
        $end = request()->input('end');
        /* Check query range */
        $startQuery = (isset($start) ? $start : $startLimit);
        $endQuery = (isset($end) ? $end : $endLimit);
        if (isset($start) && isset($end)) {
            $startQuery = ($start > $end ? $end : $start);
            $endQuery = ($start > $end ? $start : $end);
        }
        /* Date query */
        $startQuery = ($startQuery < $startLimit ? $startLimit : $startQuery);
        $startQuery = $model->asLocalTime($startQuery . ' 00:00:00');
        $startMonth = (int) Carbon::parse($startQuery)->format('m');
        $endQuery = $model->asLocalTime($endQuery . ' 23:59:59');
        /* Month range max 8 tables */
        $monthRange = [];
        $monthRange[] = (int) $now->format("m");
        if ($monthRange[0] !== $startMonth) {
            for ($i = 0; $i <= $months; $i++) {
                $now->subMonth();
                $monthTable = (int) $now->format("m");
                $monthRange[] = $monthTable;
                if ($monthTable === $startMonth) {
                    break;
                }
            }
        }
        /* Use limit month table */
        $quest = $model->whereIn('month', $monthRange);
        /* Start date query */
        $quest = $quest->where('created_at', '>=', $startQuery);
        /* End date query */
        $quest = $quest->where('created_at', '<=', $endQuery);
        /* Order by created_at */
        $quest = $quest->orderBy('created_at', 'ASC');
        
        return $quest;
    }
}