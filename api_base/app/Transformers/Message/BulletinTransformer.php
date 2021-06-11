<?php

namespace App\Transformers\Message;

use League\Fractal\TransformerAbstract;
use App\Entities\Message\Bulletin;
use App\Libraries\Instances\Swap\Matrix;
use Lang;

/**
 * Class BulletinTransformer.
 *
 * @package namespace App\Transformers\Message;
 */
class BulletinTransformer extends TransformerAbstract
{
    /**
     * Transform the Bulletin entity.
     *
     * @param \App\Entities\Message\Bulletin $model
     *
     * @return array
     */
    public function transform(Bulletin $model)
    {
        return collect([
            'id' => $model->id,
            'subject' => $model->subject,
            'content' => $model->content,
            'type' => $model->notify_type,
            'type_name' => $model->notify_type,
            'released_at' => $model->released_at,
            'expired_at' => $model->expired_at,
            'status' => $model->status,

            /* place your other model properties here */
            
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            if ($key == 'type_name') {
                return Lang::dict('auth', 'guards.' . $item, $item);
            } elseif ($key == 'subject') {
                return Lang::dict('notice', 'subject.' . $item, $item);
            } elseif ($key == 'content') {
                $dicts = Lang::dict('notice', $key, []);
                Matrix::indexReplace($item, $dicts);
                return Matrix::null2empty($item);
            } else {
                return (isset($item) ? $item : '');
            }
        })->all();
    }
}
