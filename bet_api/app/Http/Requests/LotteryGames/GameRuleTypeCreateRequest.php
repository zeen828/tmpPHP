<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameRuleTypeCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $named = $this->route()->getName();
        switch ($named) {
            /* Admin */
            case 'games.lottery.admin.setting.type.list':
                return [
                    'search' => 'string',
                    'orderBy' => 'in:id,win_rate,status',
                    'sortedBy' => 'in:asc,desc',
                    'page' => 'integer|between:1,2147483647',
                    'rows' => 'integer|between:1,100',
                    // Request Criteria not allowed query conditions.
                    'searchFields' => '!required',
                    'filter' => '!required',
                    'with' => '!required',
                    'withCount' => '!required',
                    'searchJoin' => '!required',
                ];
            case 'games.lottery.admin.setting.type.create':
                return [
                    'game_id' => '!required',
                    'name' => 'required|string',
                    'description' => 'string',
                    'sort' => 'integer|between:0,1000',
                    'status' => 'required|boolean',
                ];
            /* User */
            case 'games.lottery.bet.bet':
                return [
                    'draw_id' => 'required',
                    'rule_id' => 'required',
                    'value' => 'required',
                    'quantity' => 'required',
                    'amount' => 'required',
                ];
            default:
                return [];
        }
    }
}
