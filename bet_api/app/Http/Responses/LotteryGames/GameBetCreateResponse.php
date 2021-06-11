<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameBetCreateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameBetCreateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.bet.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
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
                })->all();
                break;
            /* User */
            case 'games.lottery.query.record':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
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
                })->all();
                break;
            case 'games.lottery.bet.order':
                // 不顯示的欄位
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
            default:
                break;
        }
    }
}
