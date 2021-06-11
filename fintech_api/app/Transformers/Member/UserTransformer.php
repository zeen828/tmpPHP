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
        $setting = $model->setting;
        $setting = collect($setting)->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();

        return collect([
            'id' => (int) $model->id,
            'uid' => $model->uid,
            'account' => $model->account,
            'password' => $model->password,
            'phone' => $model->phone,
            'email' => $model->email,
            'name' => $model->name,
            'nickname' => $model->nickname,
            'setting' => $setting,
            'status' => $model->status,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'agreed_at' => $model->agreed_at,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
