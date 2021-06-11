<?php

namespace App\Transformers\Member;

use League\Fractal\TransformerAbstract;
use App\Entities\Member\Auth;

/**
 * Class AuthTransformer.
 *
 * @package namespace App\Transformers\Member;
 */
class AuthTransformer extends TransformerAbstract
{
    /**
     * Transform the Auth entity.
     *
     * @param \App\Entities\Member\Auth $model
     *
     * @return array
     */
    public function transform(Auth $model)
    {
        return collect([
            /* id */
            'id' => (int) $model->id,
            'uid' => $model->uid,

            /* place your other model properties here */
            'source' => $model->source,
            'parent_id' => $model->parent_id,
            'parent_level' => $model->parent_level,
            'level' => $model->level,
            'account' => $model->account,
            'oauth_token' => $model->oauth_token,
            'password_extract' => $model->password_extract,
            'rebate' => $model->rebate,
            'remark' => $model->remark,
            'delay' => $model->delay,

            /* Status */
            'freeze' => $model->freeze,
            'status' => $model->status,

            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
