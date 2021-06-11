<?php

namespace App\Http\Requests\Member;

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
            /* Admin */
            case 'member.admin.setting.user.list':
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
            case 'member.auth.login':
                return [
                    // 'source' => 'required|integer',
                    'account' => 'required|integer',
                    'oauth_token' => 'required',
                    'uid' => 'between:7,32',
                ];
            /* Docking */
            case 'docking.user.signature.login':
                return [
                    'signature' => 'required|string',
                    'uid' => 'between:7,32',
                    'debug' => 'integer',
                ];
            case 'docking.receipt.point.add':
                return [
                    'signature' => 'required|string',
                    'amount' => 'required|integer',
                    'receipt' => 'required|string',
                    'debug' => 'integer',
                ];
            case 'docking.receipt.point.del':
                return [
                    'amount' => 'required|integer',
                    'debug' => 'integer',
                ];
            default:
                return [
                    //
                ];
        }
    }
}
