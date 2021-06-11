<?php

namespace App\Criteria\LotteryGames\GameSetting;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AdminCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameSetting;
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
        return $model;
    }
}
