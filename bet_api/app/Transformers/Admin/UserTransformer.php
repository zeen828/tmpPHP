<?php

namespace App\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Entities\Admin\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers\Admin;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\Admin\User $model
     *
     * @return array
     */
    public function transform(User $model)
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
