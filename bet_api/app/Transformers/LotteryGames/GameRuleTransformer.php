<?php

namespace App\Transformers\LotteryGames;

use League\Fractal\TransformerAbstract;
use App\Entities\LotteryGames\GameRule;

/**
 * Class GameRuleTransformer.
 *
 * @package namespace App\Transformers\LotteryGames;
 */
class GameRuleTransformer extends TransformerAbstract
{
    /**
     * Transform the GameRule entity.
     *
     * @param \App\Entities\LotteryGames\GameRule $model
     *
     * @return array
     */
    public function transform(GameRule $model)
    {
         return collect([
            'id' => (int) $model->id,
            /* place your other model properties here */
            'game_id' => $model->game_id,
            'game' => $model->rGameSetting->name,
            'type_id' => $model->type_id,
            'name' => $model->name,
            'description' => $model->description,
            'rule_json' => $model->rule_json,
            'bet_json' => $model->bet_json,
            'odds' => $model->odds,
            'sort' => $model->sort,
            'status' => $model->status,
            /* Timezone datetime */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ])->map(function ($item, $key) {
            return (isset($item) ? $item : '');
        })->all();
    }
}
