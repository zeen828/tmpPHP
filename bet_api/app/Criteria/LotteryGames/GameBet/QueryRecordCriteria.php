<?php

namespace App\Criteria\LotteryGames\GameBet;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use TokenAuth;
use App\Exceptions\Jwt\AuthExceptionCode;

/**
 * Class QueryRecordCriteria.
 *
 * @package namespace App\Criteria\LotteryGames\GameBet;
 */
class QueryRecordCriteria implements CriteriaInterface
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
        if ($user = TokenAuth::getUser()) {

            $userId = $user->id;
            // $userId = '1';

            $model = $model->where('user_id', $userId);

            return $model;

        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
