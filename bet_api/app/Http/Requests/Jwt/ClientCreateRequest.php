<?php

namespace App\Http\Requests\Jwt;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            case 'auth.client.build':
                return [
                    'name' => 'required|between:1,128',
                    'ban' => [
                        'required',
                        'integer',
                        'between:0,' . (count(config('ban.release')) - 1)
                    ]
                ];
            case 'auth.client.index':
                return [
                    'start' => 'date_format:Y-m-d',
                    'end' => 'date_format:Y-m-d',
                    'page' => 'required|integer|between:1,' . PHP_INT_MAX,
                    'rows' => 'integer|between:1,1000'
                ];
            default:
                return [];
        }
    }
}
