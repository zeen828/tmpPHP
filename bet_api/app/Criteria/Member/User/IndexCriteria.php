<?php

namespace App\Criteria\Member\User;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\Member\User;
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
        /* Date range */
        $start = request()->input('start');
        $end = request()->input('end');
        /* Check query range */
        $startQuery = (isset($start) ? $start : null);
        $endQuery = (isset($end) ? $end : null);
        if (isset($start) && isset($end)) {
            $startQuery = ($start > $end ? $end : $start);
            $endQuery = ($start > $end ? $start : $end);
        }
        /* Start date query */
        if (isset($startQuery)) {
            $startQuery = $model->asLocalTime($startQuery . ' 00:00:00');
            $quest = $model->where('created_at', '>=', $startQuery);
        }
        /* End date query */
        if (isset($endQuery)) {
            $endQuery = $model->asLocalTime($endQuery . ' 23:59:59');
            if (isset($quest)) {
                $quest = $quest->where('created_at', '<=', $endQuery);
            } else {
                $quest = $model->where('created_at', '<=', $endQuery);
            }
        }
        /* Order by created_at */
        if (isset($quest)) {
            $quest = $quest->orderBy('created_at', 'ASC');
        } else {
            $quest = $model->orderBy('created_at', 'ASC');
        }

        return $quest;
    }
}
