<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameRuleTypeUpdateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.type.update':
                return [
                    'game_id' => '!required',
                    'name' => 'string',
                    'description' => 'string',
                    'sort' => 'between:0,1000',
                    'status' => 'boolean',
                ];
            /* User */
            default:
                return [];
        }
    }
}
