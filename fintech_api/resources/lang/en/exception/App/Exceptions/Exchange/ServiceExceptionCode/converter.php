<?php
use App\Exceptions\Exchange\ServiceExceptionCode as ExceptionCode;
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
            ExceptionCode::UNAVAILABLE_SERVICE => [
                'code' => (string) ExceptionCode::UNAVAILABLE_SERVICE,
                'status' => '403',
                'message' => 'Service is unavailable.'
            ], 
            ExceptionCode::UNAUTHORIZED_IP => [
                'code' => (string) ExceptionCode::UNAUTHORIZED_IP,
                'status' => '401',
                'message' => 'Unauthorized IP : \'%ip%\' .'
            ],
            ExceptionCode::BILLING_TYPE_UNDEFINED => [
                'code' => (string) ExceptionCode::BILLING_TYPE_UNDEFINED,
                'status' => '403',
                'message' => 'Undefined billing type.'
            ],
            ExceptionCode::BILLING_LINK_CREATE_FAIL => [
                'code' => (string) ExceptionCode::BILLING_LINK_CREATE_FAIL,
                'status' => '507',
                'message' => 'Authorization of billing link signature failed.'
            ],
            ExceptionCode::BILLING_AUTH_FAIL => [
                'code' => (string) ExceptionCode::BILLING_AUTH_FAIL,
                'status' => '403',
                'message' => 'Invalid bill voucher.'
            ],
            ExceptionCode::BILLING_TO_PAYMENT_FAIL => [
                'code' => (string) ExceptionCode::BILLING_TO_PAYMENT_FAIL,
                'status' => '403',
                'message' => 'Payment failed : %message%'
            ],
            ExceptionCode::INVALID_ORDER_STATUS => [
                'code' => (string) ExceptionCode::INVALID_ORDER_STATUS,
                'status' => '403',
                'message' => 'Inoperable state.'
            ],
            ExceptionCode::ORDER_TYPE_WRONG => [
                'code' => (string) ExceptionCode::ORDER_TYPE_WRONG,
                'status' => '403',
                'message' => 'Inoperable order type.'
            ],
        ]
    ]
];
