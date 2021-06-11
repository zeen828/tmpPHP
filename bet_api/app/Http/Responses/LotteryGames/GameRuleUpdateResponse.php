<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameRuleUpdateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameRuleUpdateResponse extends ResponseFactory
{

    /**
     * Transform the data response.
     *
     * @param array &$data
     * 
     * @return void
     */
    public function transform(array &$data)
    {
        // Adjust the response format data label
        $named = request()->route()->getName();
        switch ($named) {
            /* Admin */
            /* data */
            case 'games.lottery.admin.setting.rule.update':
                // 不顯示的欄位
                $data = collect($data['data'])->forget([
                    'id',
                    'game_id',
                    // 'type_id',
                    'rule_json',
                    'bet_json',
                    'created_at',
                    'updated_at',
                ])->all();
                break;
            /* User */
            default:
                break;
        }
    }
}
