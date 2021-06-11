<?php

namespace App\Criteria\Trade\Log;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon;
use SystemParameter;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\Trade\Log;
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
        $months = SystemParameter::getValue('trade_query_limit_months');
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
        /* User */
        if ($user = $repository->questUser()) {
            /* User account types */
            $accounts = $user->heldCurrencyModels();
            /* Currency */
            if ($currency = $repository->questCurrency()) {
                if (in_array($currency, $accounts)) {
                    $accounts = [$currency];
                } else {
                    $accounts = [];
                }
            }
            /* Quest conditions */
            if (count($accounts) > 0) {
                $quest->where('accountable_id', '=', $user->trade_account_id);
                $quest->whereIn('accountable_type', $accounts);
            }
        } else {
            /* All account types */
            $accounts = $model->getTradeAccountables();
            /* Currency */
            if ($currency = $repository->questCurrency()) {
                if (in_array($currency, $accounts)) {
                    $accounts = [$currency];
                } else {
                    $accounts = [];
                }
            }
            /* Quest conditions */
            foreach($accounts as $key => $account) {
                if (! $model->isTradeAccountableAllowed($account)) {
                    unset($accounts[$key]);
                } else {
                    $quest = $quest->where(function ($query) use ($model, $account) {
                        $query->where('accountable_type', $account);
                        $query->whereIn('holderable_type', $model->takeTradeAccountableHolders($account));
                    });
                }
            }
        }
        /* Check account count */
        if (count($accounts) == 0) {
            $quest->where('accountable_type', '=', '');
        }
        /* Order by created_at */
        $quest = $quest->orderBy('created_at', 'ASC');
        
        return $quest;
    }
}