<?php

namespace App\Criteria\LotteryGames\GameSetting;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameSetting;
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
        /* Don't show status false */
        $model = $model->where('status', '1');

        return $model;
    }
}
