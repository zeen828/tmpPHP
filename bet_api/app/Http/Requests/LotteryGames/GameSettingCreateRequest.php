<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameSettingCreateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.game.list':
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
            case 'games.lottery.admin.setting.game.create':
                return [
                    'name' => 'required|string',
                    'general_data_json' => 'required|json',
                    'general_digits' => 'required|integer|between:0,20',
                    'general_repeat' => 'required|boolean',
                    'special_data_json' => 'json',
                    'special_digits' => 'integer|between:0,20',
                    'special_repeat' => 'boolean',
                    'week' => 'required|json',
                    'start_t' => 'required|date_format:H:i:s',
                    'end_t' => 'date_format:H:i:s',
                    'stop_enter' => 'required|integer|between:0,86400',
                    'repeat' => 'required|integer|between:0,86400',
                    'reservation' => 'required|boolean',
                    'win_rate' => 'numeric|between:0,99.999',
                    'status' => 'required|boolean',
                ];
            /* User */
            default:
                return [];
        }
    }
}
