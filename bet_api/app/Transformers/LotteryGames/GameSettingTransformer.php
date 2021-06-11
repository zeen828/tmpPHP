<?php

namespace App\Transformers\LotteryGames;

use League\Fractal\TransformerAbstract;
use App\Entities\LotteryGames\GameSetting;

/**
 * Class GameSettingTransformer.
 *
 * @package namespace App\Transformers\LotteryGames;
 */
class GameSettingTransformer extends TransformerAbstract
{
    /**
     * Transform the GameSetting entity.
     *
     * @param \App\Entities\LotteryGames\GameSetting $model
     *
     * @return array
     */
    public function transform(GameSetting $model)
    {
         return collect([
            'id' => (int) $model->id,
            /* place your other model properties here */
            'name' => $model->name,
            'description' => $model->description,
            'general_data_json' => $model->general_data_json,
            'general_digits' => $model->general_digits,
            'general_repeat' => $model->general_repeat,
            'special_data_json' => $model->special_data_json,
            'special_digits' => $model->special_digits,
            'special_repeat' => $model->special_repeat,
            'week' => $model->week,
            'start_t' => $model->start_t,
            'end_t' => $model->end_t,
            'stop_enter' => $model->stop_enter,
            'repeat' => $model->repeat,
            'reservation' => $model->reservation,
            'win_rate' => $model->win_rate,
            'status' => $model->status,
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
