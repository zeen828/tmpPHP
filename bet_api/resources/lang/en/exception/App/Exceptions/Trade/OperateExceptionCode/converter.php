<?php
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;

return [
    /*
     * |--------------------------------------------------------------------------
     * | Default exception error message
     * |--------------------------------------------------------------------------
     * |
     * | The default message that responds to an exception error.
     * |
     * | Example :
     * | 'default' => [
     * |   'code' => (string) thrown error code,
     * |   'status' => (string) thrown status code,
     * |   'message' => (string) thrown error message
     * | ]
     */

    'default' => [
        'code' => (string) ExceptionCode::NORMAL,
        'status' => '500',
        'message' => 'Something error happens.'
    ],
    
    /*
    * |--------------------------------------------------------------------------
    * | Exception information conversion language lines
    * |--------------------------------------------------------------------------
    * |
    * | The status code is bound to the list of information thrown by the corresponding exception error code conversion.
    * |
    * | Example :
    * |   'customize' => [
    * |    (int) source http status code => [
    * |           (mixed) source error code => [
    * |           'code' => (string) thrown error code,
    * |           'status' => (string) thrown status code,
    * |           'message' => (string) thrown error message
    * |           ],
    * |       ],
    * |    ]
    */
    
    'customize' => [
        500 => [
            ExceptionCode::NORMAL => [
                'code' => (string) ExceptionCode::NORMAL,
                'status' => '500',
                'message' => 'Something error happens.'
            ],
            ExceptionCode::INVALID_AMOUNT => [
                'code' => (string) ExceptionCode::INVALID_AMOUNT,
                'status' => '403',
                'message' => 'Invalid transaction.'
            ],
            ExceptionCode::INSUFFICIENT_AMOUNT => [
                'code' => (string) ExceptionCode::INSUFFICIENT_AMOUNT,
                'status' => '403',
                'message' => 'Insufficient amount.'
            ],
            ExceptionCode::ACCOUNTABLE_UNDEFINED => [
                'code' => (string) ExceptionCode::ACCOUNTABLE_UNDEFINED,
                'status' => '403',
                'message' => 'Unauthorized trading account type.'
            ],
            ExceptionCode::SOURCEABLE_UNDEFINED => [
                'code' => (string) ExceptionCode::SOURCEABLE_UNDEFINED,
                'status' => '403',
                'message' => 'Unauthorized trading source type.'
            ],
            ExceptionCode::TRADE_UNSTARTED => [
                'code' => (string) ExceptionCode::TRADE_UNSTARTED,
                'status' => '500',
                'message' => 'Transaction submission failed.'
            ],
            ExceptionCode::NON_PERMITTED_TRADE_OBJECT => [
                'code' => (string) ExceptionCode::NON_PERMITTED_TRADE_OBJECT,
                'status' => '403',
                'message' => 'Non-permitted trading object.'
            ],
            ExceptionCode::SREVICE_SUSPENDED => [
                'code' => (string) ExceptionCode::SREVICE_SUSPENDED,
                'status' => '403',
                'message' => 'Transaction service system suspended.'
            ],
            ExceptionCode::UNKNOWN_OBJECT_FROM_SOURCEABLE => [
                'code' => (string) ExceptionCode::UNKNOWN_OBJECT_FROM_SOURCEABLE,
                'status' => '403',
                'message' => 'Unknown trading source object.'
            ],
            ExceptionCode::UNKNOWN_OBJECT_FROM_ACCOUNTABLE => [
                'code' => (string) ExceptionCode::UNKNOWN_OBJECT_FROM_ACCOUNTABLE,
                'status' => '403',
                'message' => 'Unknown trading account object.'
            ],
            ExceptionCode::ACCOUNT_FROZEN => [
                'code' => (string) ExceptionCode::ACCOUNT_FROZEN,
                'status' => '403',
                'message' => 'Trading account has been frozen.'
            ],
            ExceptionCode::UNKNOWN_ORDER_FROM_PARENT => [
                'code' => (string) ExceptionCode::UNKNOWN_ORDER_FROM_PARENT,
                'status' => '403',
                'message' => 'Unknown order from parent order.'
            ],
            ExceptionCode::UNAUTHORIZED_OPERATION => [
                'code' => (string) ExceptionCode::UNAUTHORIZED_OPERATION,
                'status' => '403',
                'message' => 'Unauthorized operation.'
            ],
            ExceptionCode::SIGNATURE_CREATE_FAIL => [
                'code' => (string) ExceptionCode::SIGNATURE_CREATE_FAIL,
                'status' => '507',
                'message' => 'Signature creation failed.'
            ],
            ExceptionCode::UNUSUALLY_FROZEN_ACCOUNT => [
                'code' => (string) ExceptionCode::UNUSUALLY_FROZEN_ACCOUNT,
                'status' => '403',
                'message' => 'Trading account has been frozen.'
            ],
            ExceptionCode::INVALID_ACCOUNT_ID => [
                'code' => (string) ExceptionCode::INVALID_ACCOUNT_ID,
                'status' => '403',
                'message' => 'Invalid account.'
            ],
            ExceptionCode::SOURCE_OPERATION_DISABLED => [
                'code' => (string) ExceptionCode::SOURCE_OPERATION_DISABLED,
                'status' => '403',
                'message' => 'Source operation has been disabled.'
            ],
            ExceptionCode::INVALID_BALANCE => [
                'code' => (string) ExceptionCode::INVALID_BALANCE,
                'status' => '403',
                'message' => 'Invalid transaction.'
            ],
        ]
    ]
];
