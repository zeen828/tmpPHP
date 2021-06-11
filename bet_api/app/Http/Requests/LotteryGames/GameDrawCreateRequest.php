<?php

namespace App\Http\Requests\LotteryGames;

use Illuminate\Foundation\Http\FormRequest;

class GameDrawCreateRequest extends FormRequest
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
            case 'games.lottery.admin.setting.draw.list':
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
            case 'games.lottery.query.history':
                return [
                    'period' => 'size:13',
                    'start' => 'date_format:Y-m-d',
                    'end' => 'date_format:Y-m-d',
                    'page' => 'integer|between:1,2147483647',
                    'rows' => 'integer|between:1,100',
                ];
            default:
                return [];
        }
    }
}
