<?php
use App\Exceptions\Business\ServiceExceptionCode as ExceptionCode;
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
            ExceptionCode::AUTH_LINK_CREATE_FAIL => [
                'code' => (string) ExceptionCode::AUTH_LINK_CREATE_FAIL,
                'status' => '507',
                'message' => 'Link signature creation failed.'
            ],
            ExceptionCode::USER_TYPE_NOT_SUPPORT => [
                'code' => (string) ExceptionCode::USER_TYPE_NOT_SUPPORT,
                'status' => '403',
                'message' => 'User type is not supported.'
            ],
            ExceptionCode::INVALID_USER => [
                'code' => (string) ExceptionCode::INVALID_USER,
                'status' => '403',
                'message' => 'Invalid user object.'
            ],
            ExceptionCode::INVITE_LINK_CREATE_FAIL => [
                'code' => (string) ExceptionCode::INVITE_LINK_CREATE_FAIL,
                'status' => '507',
                'message' => 'Link signature creation failed.'
            ],
            ExceptionCode::INVITER_TYPE_NOT_SUPPORT => [
                'code' => (string) ExceptionCode::INVITER_TYPE_NOT_SUPPORT,
                'status' => '403',
                'message' => 'Inviter type is not supported.'
            ],
            ExceptionCode::INVALID_INVITER => [
                'code' => (string) ExceptionCode::INVALID_INVITER,
                'status' => '403',
                'message' => 'Invalid inviter object.'
            ],
            ExceptionCode::UNAVAILABLE_INVITE => [
                'code' => (string) ExceptionCode::UNAVAILABLE_INVITE,
                'status' => '403',
                'message' => 'Unavailable invitation.'
            ],
            ExceptionCode::NON_PERMITTED_INVITER_OBJECT => [
                'code' => (string) ExceptionCode::NON_PERMITTED_INVITER_OBJECT,
                'status' => '403',
                'message' => 'Non-permitted inviter object.'
            ],
            ExceptionCode::INVALID_SIGNATURE => [
                'code' => (string) ExceptionCode::INVALID_SIGNATURE,
                'status' => '401',
                'message' => 'Invalid signature authorization.'
            ],
        ]
    ]
];