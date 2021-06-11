<?php

namespace App\Http\Responses\LotteryGames;

use Illuminate\Routing\ResponseFactory;

/**
 * Class GameRuleCreateResponse.
 *
 * @package App\Http\Responses\LotteryGames
 */
class GameRuleCreateResponse extends ResponseFactory
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
            case 'games.lottery.admin.setting.rule.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'id',
                        'game_id',
                        // 'type_id',
                        'rule_json',
                        'bet_json',
                        'created_at',
                        'updated_at',
                    ])->all();
                })->all();
                break;
            /* data */
            case 'games.lottery.admin.setting.rule.create':
            case 'games.lottery.admin.setting.rule.show':
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
            case 'games.lottery.bet.rule.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'game_id',
                        // 'type_id',
                        'rule_json',
                        'sort',
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
