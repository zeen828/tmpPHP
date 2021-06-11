<?php

namespace App\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Entities\Admin\Auth;

/**
 * Class AuthTransformer.
 *
 * @package namespace App\Transformers\Admin;
 */
class AuthTransformer extends TransformerAbstract
{
    /**
     * Transform the Auth entity.
     *
     * @param \App\Entities\Admin\Auth $model
     *
     * @return array
     */
    public function transform(Auth $model)
    {
        return collect([
            'id' => (int) $model->id,
            'uid' => $model->uid,
            'account' => $model->account,
            'password' => $model->password,
            'email' => $model->email,
            'name' => $model->name,
            'status' => $model->status,
            'authority' => $model->authority,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
