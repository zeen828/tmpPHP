<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameBetUpdateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameBetUpdateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.bet.update':
                // 不顯示的欄位
                $data = collect($data['data'])->forget([
                    'id',
                    'source_type',
                    'source_id',
                    'user_type',
                    'user_id',
                    'game_id',
                    'draw_id',
                    'rule_id',
                    'win_sys',
                    // 'created_at',
                    'updated_at',
                ])->all();
                break;
            /* User */
            default:
                break;
        }
    }
}
