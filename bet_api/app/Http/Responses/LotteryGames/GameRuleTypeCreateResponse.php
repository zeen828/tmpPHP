<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameRuleTypeCreateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameRuleTypeCreateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.type.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'game_id',
                        'created_at',
                        'updated_at',
                    ])->all();
                })->all();
                break;
            /* data */
            case 'games.lottery.admin.setting.type.create':
            case 'games.lottery.admin.setting.type.show':
                // 不顯示的欄位
                $data = collect($data['data'])->forget([
                    'game_id',
                    'created_at',
                    'updated_at',
                ])->all();
                break;
            /* User */
            case 'games.lottery.query.info':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'id',
                        'general_data_json',
                        'general_digits',
                        'general_repeat',
                        'special_data_json',
                        'special_digits',
                        'special_repeat',
                        'repeat',
                        'reservation',
                        'win_rate',
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
