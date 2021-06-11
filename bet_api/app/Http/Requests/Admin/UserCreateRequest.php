<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            case 'admin.user.index':
                return [
                    'start' => 'date_format:Y-m-d',
                    'end' => 'date_format:Y-m-d',
                    'page' => 'required|integer|between:1,' . PHP_INT_MAX,
                    'rows' => 'integer|between:1,1000'
                ];
            case 'admin.user.logon':
                return [
                    'account' => 'required|email'
                ];
            case 'admin.user.resend.auth':
                return [
                    'reset' => 'required|boolean'
                ];
            default:
                return [];
        }
    }
}