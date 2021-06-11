<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
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
            case 'business.auth.link':
                return [
                    'type' => 'required'
                ];
            case 'business.invite.link':
                return [
                    'type' => 'required'
                ];
            case 'business.invite.auth':
                return [
                    'signature' => 'required|size:72'
                ];
            default:
                return [];
        }
    }
}
