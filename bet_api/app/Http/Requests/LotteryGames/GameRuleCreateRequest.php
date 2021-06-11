<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameRuleCreateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.rule.list':
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
            case 'games.lottery.admin.setting.rule.create':
                return [
                    'game_id' => '!required',
                    'type_id' => 'required|integer|between:0,500',
                    'name' => 'required|string',
                    'description' => 'string',
                    'rule_json' => 'required|json',
                    'bet_json' => 'required|json',
                    'odds' => 'numeric|between:0,99.999',
                    'sort' => 'integer|between:0,1000',
                    'status' => 'required|boolean',
                ];
            /* User */
            default:
                return [];
        }
    }
}
