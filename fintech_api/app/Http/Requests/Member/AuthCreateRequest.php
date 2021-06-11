<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class AuthCreateRequest extends FormRequest
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
            case 'member.auth.logon':
                return [
                    'account' => 'required|between:8,128',
                    'password' => 'required|between:8,16',
                    'password_confirmation' => 'required|between:8,16',
                    'phone' => 'required|phone:AUTO,mobile',
                    'verifycode' => 'required|integer|between:10000,99999',
                    'agree_terms' => 'required|boolean'
                ];
            case 'member.auth.phone.login':
                    return [
                        'phone' => 'required|phone:AUTO,mobile',
                        'verifycode' => 'required|integer|between:10000,99999'
                    ];
            case 'member.auth.verifycode':
                return [
                    'phone' => 'required|phone:AUTO,mobile'
                ];
            default:
                return [
                    //
                ];
        }
    }
}
