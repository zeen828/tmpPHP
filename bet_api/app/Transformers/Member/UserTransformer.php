<?php

namespace App\Transformers\Member;

use League\Fractal\TransformerAbstract;
use App\Entities\Member\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers\Member;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\Member\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return collect([
            'id' => (int) $model->id,
            'uid' => $model->uid,

            /* place your other model properties here */
            'source' => $model->source,
            'parent_id' => $model->parent_id,
            'account' => $model->account,
            'delay' => $model->delay,
            'status' => $model->status,

            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
