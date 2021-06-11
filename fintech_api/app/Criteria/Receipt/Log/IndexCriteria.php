<?php

namespace App\Criteria\Receipt\Log;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon;
use SystemParameter;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\Receipt\Log;
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
        $months = SystemParameter::getValue('receipt_query_limit_months');
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
        /* All form types */
        $forms = $model->getReceiptFormdefines();
        foreach($forms as $code => $form) {
            if (! $model->isReceiptFormdefineAllowed($form)) {
                unset($forms[$code]);
            }
        }
        if (count($forms) > 0) {
            $quest->whereIn('formdefine_code', array_keys($forms));
        } else {
            $quest->where('formdefine_code', '=', null);
        }
        /* Source */
        if ($source = $repository->questSource()) {
            $quest->where('sourceable_id', '=', $source->id);
            $quest->where('sourceable_type', get_class($source));
        }
        /* Order by created_at */
        $quest = $quest->orderBy('created_at', 'ASC');
        
        return $quest;
    }
}
