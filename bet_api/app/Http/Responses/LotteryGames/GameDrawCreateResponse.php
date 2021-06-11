<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameDrawCreateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameDrawCreateResponse extends ResponseFactory
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
            /* data list */
            case 'games.lottery.admin.setting.draw.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'id',
                        'game_id',
                        'ready_at',
                        'start_at',
                        'stop_at',
                        'draw_rule_json',
                        'redeem',
                        'created_at',
                        'updated_at',
                    ])->all();
                })->all();
                break;
            /* User */
            case 'games.lottery.query.history':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'id',
                        'game_id',
                        'ready_at',
                        'start_at',
                        'stop_at',
                        'draw_rule_json',
                        'redeem',
                        'created_at',
                        'updated_at',
                    ])->all();
                })->all();
                break;
            default:
                break;

        }
    }
}
