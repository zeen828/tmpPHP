<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class AuthUpdateRequest extends FormRequest
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
            case 'member.auth.change.password':
                return [
                    'password' => 'required|between:8,16',
                    'password_confirmation' => 'required|between:8,16'
                ];
            case 'member.auth.edit.profile':
                return [
                    'email' => 'email',
                    'name' => 'between:1,128',
                    'nickname' => 'between:1,128',
                ];
            case 'member.auth.edit.setting':
                return [
                    'bank' => 'between:1,256',
                    'line' => 'between:1,256',
                ];
            case 'member.auth.change.pin':
                return [
                    'pin' => [
                        'required',
                        'string',
                        'size:6',
                        'regex:/^[0-9]+$/'
                    ],
                    'pin_confirmation' => [
                        'required',
                        'string',
                        'size:6',
                        'regex:/^[0-9]+$/'
                    ]
                ];
            default:
                return [
                    //
                ];
        }
    }
}
