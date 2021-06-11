<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameDrawUpdateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameDrawUpdateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.draw.update':
                // 不顯示的欄位
                $data = collect($data['data'])->forget([
                    'id',
                    'game_id',
                    'ready_at',
                    'start_at',
                    'stop_at',
                    'draw_rule_json',
                    'bet_quantity',
                    'bet_amount',
                    'draw_quantity',
                    'draw_amount',
                    'draw_rate',
                    'redeem',
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
