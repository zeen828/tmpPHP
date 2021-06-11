<?php

namespace App\Http\Requests\Exchange;

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
            case 'exchange.billing.link':
                return [
                    'amount' => 'required',
                    'type' => 'required'
                ];
            case 'exchange.manual.billing':
                return [
                    'amount' => 'required|amount_verifier:' . config('exchange.min_manual_billing_amount') . ',' . config('exchange.max_manual_billing_amount'),
                    'name' => 'between:1,50',
                    'desc' => 'between:1,50',
                    'remark' => 'between:1,50',
                ];
            case 'exchange.manual.payment':
                return [
                    'remark' => 'between:1,50',
                ];
            case 'exchange.manual.deposit':
                return [
                    'remark' => 'between:1,50',
                ];
            case 'exchange.manual.interrupt':
                return [
                    'remark' => 'between:1,50',
                ];
            case 'exchange.withdraw.deposit':
                return [
                    'amount' => 'required|amount_verifier:' . config('exchange.min_withdraw_amount') . ',' . config('exchange.max_withdraw_amount'),
                    'remark' => 'between:1,50',
                    'pin' => [
                        'required',
                        'string',
                        'size:6',
                        'regex:/^[0-9]+$/'
                    ],
                ];
            case 'exchange.withdraw.remittance':
                return [
                    'remark' => 'between:1,50',
                ];
            case 'exchange.withdraw.finish':
                return [
                    'remark' => 'between:1,50',
                ];
            case 'exchange.withdraw.cancel':
                return [
                    'remark' => 'between:1,50',
                ];
            default:
                return [];
        }
    }
}
