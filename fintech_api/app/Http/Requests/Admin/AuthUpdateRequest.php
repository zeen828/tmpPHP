<?php

namespace App\Http\Requests\Admin;

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
            case 'admin.auth.change.password':
                return [
                    'password' => 'required|between:8,16',
                    'password_confirmation' => 'required|between:8,16'
                ];
            case 'admin.auth.edit.profile':
                return [
                    'email' => 'email',
                    'name' => 'between:1,128',
                ];
            default:
                return [
                    //
                ];
        }
    }
}
