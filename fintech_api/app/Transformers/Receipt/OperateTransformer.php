<?php

namespace App\Transformers\Receipt;

use League\Fractal\TransformerAbstract;
use App\Entities\Receipt\Operate;
use App\Libraries\Instances\Swap\Matrix;
use Lang;

/**
 * Class OperateTransformer.
 *
 * @package namespace App\Transformers\Receipt;
 */
class OperateTransformer extends TransformerAbstract
{
    /**
     * Transform the Operate entity.
     *
     * @param \App\Entities\Receipt\Operate $model
     *
     * @return array
     */
    public function transform(Operate $model)
    {
        return collect([
            'order' => $model->order,
            'serial' => $model->serial,
            'source_id' => $model->source_id,
            'source' => $model->source,
            'source_name' => $model->source,
            'code' => $model->code,
            'form' => $model->form,
            'form_name' => $model->form,
            'status' => $model->status,
            'memo' => $model->memo,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            if ($key == 'source_name') {
                return Lang::dict('receipt', 'sourceables.' . $item, $item);
            } elseif ($key == 'form_name') {
                return Lang::dict('receipt', 'formdefines.' . $item, $item);
            } elseif ($key == 'memo') {
                $dicts = Lang::dict('receipt', $key, []);
                Matrix::indexReplace($item, $dicts);
                return Matrix::null2empty($item);
            } else {
                return (isset($item) ? $item : '');
            }
        })->all();
    }
}