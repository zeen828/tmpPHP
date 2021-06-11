<?php

namespace App\Criteria\Member\User;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use TokenAuth;

/**
 * Class AdminCriteria.
 *
 * @package namespace App\Criteria\Member\User;
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
        /* Client source */
        $client = TokenAuth::getClient();
        $model = $model->where('source_type', get_class($client));
        $model = $model->where('source_id', $client->id);

        return $model;
    }
}
