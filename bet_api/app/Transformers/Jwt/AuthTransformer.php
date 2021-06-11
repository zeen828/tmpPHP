<?php

namespace App\Transformers\Jwt;

use League\Fractal\TransformerAbstract;
use App\Entities\Jwt\Auth;

/**
 * Class AuthTransformer.
 *
 * @package namespace App\Transformers\Jwt;
 */
class AuthTransformer extends TransformerAbstract
{

    /**
     * Transform the Auth entity.
     *
     * @param \App\Entities\Jwt\Auth $model
     *
     * @return array
     */
    public function transform(Auth $model)
    {
        return collect([
            'id' => (int) $model->id,
            'app_id' => $model->app_id,
            'name' => $model->name,
            'client_id' => $model->client_id,
            'client_secret' => $model->real_client_secret,
            'ban' => $model->ban,
            'description' => $model->description,
            'status' => $model->status,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
