<?php

namespace App\Transformers\LotteryGames;

use League\Fractal\TransformerAbstract;
use App\Entities\LotteryGames\GameDraw;

/**
 * Class GameDrawTransformer.
 *
 * @package namespace App\Transformers\LotteryGames;
 */
class GameDrawTransformer extends TransformerAbstract
{
    /**
     * Transform the GameDraw entity.
     *
     * @param \App\Entities\LotteryGames\GameDraw $model
     *
     * @return array
     */
    public function transform(GameDraw $model)
    {
         return collect([
            'id' => (int) $model->id,
            /* place your other model properties here */
            'mid' => $model->mid,
            'game_id' => $model->game_id,
            'game' => $model->rGameSetting->name,
            'period' => $model->period,
            'ready_at' => $model->ready_at,
            'draw_at' => $model->draw_at,
            'start_at' => $model->start_at,
            'stop_at' => $model->stop_at,
            'general_draw' => $model->general_draw,
            'special_draw' => $model->special_draw,
            'draw_rule_json' => $model->draw_rule_json,
            'bet_quantity' => $model->bet_quantity,
            'bet_amount' => $model->bet_amount,
            'draw_quantity' => $model->draw_quantity,
            'draw_amount' => $model->draw_amount,
            'draw_rate' => $model->draw_rate,
            'redeem' => $model->redeem,
            'status' => $model->status,
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
