<?php

namespace App\Criteria\Trade\Account;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use DB;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\Trade\Account;
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
        /* Use holder models list */
        if (count($model->getHolderModels()) > 0) {
            $quest = $model->whereIn('holderable_type', $model->getHolderModels());
        } else {
            $quest = $model->where('holderable_type', '=', '');
        }
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
            $quest = $quest->where('created_at', '>=', $startQuery);
        }
        /* End date query */
        if (isset($endQuery)) {
            $endQuery = $model->asLocalTime($endQuery . ' 23:59:59');
            $quest = $quest->where('created_at', '<=', $endQuery);
        }
        /* Order by created_at */
        $quest = $quest->orderBy('created_at', 'ASC');

        return $quest;
    }
}
