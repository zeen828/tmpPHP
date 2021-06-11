<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameSettingUpdateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameSettingUpdateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.game.update':
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
            default:
                break;
        }
    }
}
