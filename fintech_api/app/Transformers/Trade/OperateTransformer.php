<?php

namespace App\Transformers\Trade;

use League\Fractal\TransformerAbstract;
use App\Entities\Trade\Operate;
use App\Libraries\Instances\Swap\Matrix;
use Lang;

/**
 * Class OperateTransformer.
 *
 * @package namespace App\Transformers\Trade;
 */
class OperateTransformer extends TransformerAbstract
{
    /**
     * Transform the Operate entity.
     *
     * @param \App\Entities\Trade\Operate $model
     *
     * @return array
     */
    public function transform(Operate $model)
    {
        return collect([
            'order' => $model->order,
            'serial' => $model->serial,
            'account' => $model->account,
            'currency' => $model->currency,
            'currency_name' => $model->currency,
            'source_id' => $model->source_id,
            'source' => $model->source,
            'source_name' => $model->source,
            'operate' => $model->operate,
            'amount' => $model->amount,
            'balance' => $model->balance,
            'code' => $model->code,
            'memo' => $model->memo,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            if ($key == 'source_name') {
                return Lang::dict('trade', 'sourceables.' . $item, $item);
            } elseif ($key == 'currency_name') {
                return Lang::dict('trade', 'accountables.' . $item, $item);
            } elseif ($key == 'memo') {
                $dicts = Lang::dict('trade', $key, []);
                Matrix::indexReplace($item, $dicts);
                return Matrix::null2empty($item);
            } else {
                return (isset($item) ? $item : '');
            }
        })->all();
    }
}