<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameRuleTypeUpdateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameRuleTypeUpdateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.type.update':
                // 不顯示的欄位
                $data = collect($data['data'])->forget([
                    'game_id',
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
