<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameBetCreateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.bet.list':
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
            /* User */
            case 'games.lottery.bet.order':
                return [
                    'rule_id' => 'required|numeric',
                    'value' => 'required',
                    'amount' => 'required|numeric',
                ];
            case 'games.lottery.bet.orders':
                return [
                    'rule_id.*' => 'required|string|numeric',
                    'value.*' => 'required|string',
                    'amount.*' => 'required|string|numeric',
                ];
            default:
                return [];
        }
    }
}
