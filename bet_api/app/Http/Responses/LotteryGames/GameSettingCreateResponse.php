<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameSettingCreateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameSettingCreateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.game.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'general_data_json',
                        'general_digits',
                        'general_repeat',
                        'special_data_json',
                        'special_digits',
                        'special_repeat',
                        'reservation',
                        'created_at',
                        'updated_at',
                    ])->all();
                })->all();
                break;
            /* data */
            case 'games.lottery.admin.setting.game.create':
            case 'games.lottery.admin.setting.game.show':
                // 不顯示的欄位
                $data = collect($data['data'])->forget([
                    'general_data_json',
                    'general_digits',
                    'general_repeat',
                    'special_data_json',
                    'special_digits',
                    'special_repeat',
                    'reservation',
                    'created_at',
                    'updated_at',
                ])->all();
                break;
            /* User */
            case 'games.lottery.query.game.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'general_data_json',
                        'general_digits',
                        'general_repeat',
                        'special_data_json',
                        'special_digits',
                        'special_repeat',
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
