<?php

namespace App\Criteria\System\Parameter;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\System\Parameter;
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
        $rules = config('sp.rules', []);
        if (count($rules) > 0) {
            return $model->whereIn('slug', array_keys($rules));
        } else {
            return $model->where('slug', '');
        }
    }
}
