<?php

namespace App\Transformers\Trade;

use League\Fractal\TransformerAbstract;

/**
 * Class CurrencyTransformer.
 *
 * @package namespace App\Transformers\Trade;
 */
class CurrencyTransformer extends TransformerAbstract
{
    /**
     * Transform the Currency entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return array
     */
    public function transform($model)
    {
        return collect([
            'currency' => $model->currency,
            'account' => $model->account,
            'amount' => $model->amount,
            'holder_type' => $model->holder_type,
            'holder_id' => $model->holder_id,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
