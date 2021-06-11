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
            case 'member.auth.change.extract.password':
                return [
                    'password' => 'required|between:8,16',
                    'password_confirmation' => 'required|between:8,16'
                ];
            default:
                return [
                    //
                ];
        }
    }
}
