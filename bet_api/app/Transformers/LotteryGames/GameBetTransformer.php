<?php

namespace App\Transformers\LotteryGames;

use League\Fractal\TransformerAbstract;
use App\Entities\LotteryGames\GameBet;

/**
 * Class GameBetTransformer.
 *
 * @package namespace App\Transformers\LotteryGames;
 */
class GameBetTransformer extends TransformerAbstract
{
    /**
     * Transform the GameBet entity.
     *
     * @param \App\Entities\LotteryGames\GameBet $model
     *
     * @return array
     */
    public function transform(GameBet $model)
    {
         return collect([
            'id' => (int) $model->id,
            /* place your other model properties here */
            'source_type' => $model->source_type,
            'source_id' => $model->source_id,
            'user_type' => $model->user_type,
            'user_id' => $model->user_id,
            'game_id' => $model->game_id,
            'game' => $model->rGameSetting->name,
            'draw_id' => $model->draw_id,
            'period' => $model->period,
            'rule_id' => $model->rule_id,
            'rule' => $model->rGameRule->name,
            'value' => $model->value,
            'quantity' => $model->quantity,
            'amount' => $model->amount,
            'profit' => $model->profit,
            'win_sys' => $model->win_sys,
            'win_user' => $model->win_user,
            'status' => $model->status,
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
