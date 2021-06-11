<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameRuleUpdateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.rule.update':
                return [
                    'game_id' => '!required',
                    'type_id' => 'integer|between:0,500',
                    'name' => 'string',
                    'description' => 'string',
                    'rule_json' => 'json',
                    'bet_json' => 'json',
                    'odds' => 'numeric|between:0,99.999',
                    'sort' => 'integer|between:0,1000',
                    'status' => 'boolean',
                ];
            /* User */
            default:
                return [];
        }
    }
}
