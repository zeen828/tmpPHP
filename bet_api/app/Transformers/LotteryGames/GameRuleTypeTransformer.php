<?php

namespace App\Transformers\LotteryGames;

use League\Fractal\TransformerAbstract;
use App\Entities\LotteryGames\GameRuleType;

/**
 * Class GameRuleTypeTransformer.
 *
 * @package namespace App\Transformers\LotteryGames;
 */
class GameRuleTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the GameRuleType entity.
     *
     * @param \App\Entities\LotteryGames\GameRuleType $model
     *
     * @return array
     */
    public function transform(GameRuleType $model)
    {
         return collect([
            'id' => (int) $model->id,
            /* place your other model properties here */
            'game_id' => $model->game_id,
            'game' => $model->rGameSetting->name,
            'name' => $model->name,
            'description' => $model->description,
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
