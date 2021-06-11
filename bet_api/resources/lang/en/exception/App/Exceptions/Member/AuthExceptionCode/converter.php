<?php
use App\Exceptions\Member\AuthExceptionCode as ExceptionCode;

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
            ExceptionCode::MEMBER_USER_FREEZE => [
                'code' => (string) ExceptionCode::MEMBER_USER_FREEZE,
                'status' => '401',
                'message' => 'Freeze user credentials.'
            ],
            ExceptionCode::MEMBER_USER_REJECTED => [
                'code' => (string) ExceptionCode::MEMBER_USER_REJECTED,
                'status' => '401',
                'message' => 'Unauthorized user credentials.'
            ],
            ExceptionCode::SIGNATURE_CREATE_FAIL => [
                'code' => (string) ExceptionCode::SIGNATURE_CREATE_FAIL,
                'status' => '401',
                'message' => 'Authorization failed.'
            ],
            ExceptionCode::USER_AUTH_FAIL => [
                'code' => (string) ExceptionCode::USER_AUTH_FAIL,
                'status' => '401',
                'message' => 'Unauthorized user credentials.'
            ],
            ExceptionCode::PASSWORD_CONFIRM_FAIL => [
                'code' => (string) ExceptionCode::PASSWORD_CONFIRM_FAIL,
                'status' => '400',
                'message' => 'Password confirmation does not match.'
            ],
            ExceptionCode::DOCKING_CLIENT_FAIL => [
                'code' => (string) ExceptionCode::DOCKING_CLIENT_FAIL,
                'status' => '400',
                'message' => 'Docking server client an error.'
            ],
            ExceptionCode::DOCKING_USER_FAIL => [
                'code' => (string) ExceptionCode::DOCKING_USER_FAIL,
                'status' => '400',
                'message' => 'Docking server user an error.'
            ],
        ]
    ]
];
