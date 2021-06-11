<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameSettingUpdateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.game.update':
                return [
                    'name' => 'string',
                    'general_data_json' => 'json',
                    'general_digits' => 'integer|between:0,20',
                    'general_repeat' => 'boolean',
                    'special_data_json' => 'json',
                    'special_digits' => 'integer|between:0,20',
                    'special_repeat' => 'boolean',
                    'week' => 'json',
                    'start_t' => 'date_format:H:i:s',
                    'end_t' => 'date_format:H:i:s',
                    'stop_enter' => 'integer|between:0,86400',
                    'repeat' => 'integer|between:0,86400',
                    'reservation' => 'boolean',
                    'win_rate' => 'numeric|between:0,99.999',
                    'status' => 'boolean',
                ];
            /* User */
            default:
                return [];
        }
    }
}
