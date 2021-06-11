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
            ExceptionCode::PIN_CONFIRM_FAIL => [
                'code' => (string) ExceptionCode::PIN_CONFIRM_FAIL,
                'status' => '400',
                'message' => 'Pin code confirmation does not match.'
            ],
            ExceptionCode::SERVICE_REJECTED => [
                'code' => (string) ExceptionCode::SERVICE_REJECTED,
                'status' => '401',
                'message' => 'Unauthorized user credentials.'
            ],
            ExceptionCode::TERMS_NOT_AGREED => [
                'code' => (string) ExceptionCode::TERMS_NOT_AGREED,
                'status' => '403',
                'message' => 'Terms of member service not agreed.'
            ],
            ExceptionCode::TERMS_HAVE_AGREED => [
                'code' => (string) ExceptionCode::TERMS_HAVE_AGREED,
                'status' => '409',
                'message' => 'Member service terms are already agreed.'
            ],
            ExceptionCode::PIN_FAIL => [
                'code' => (string) ExceptionCode::PIN_FAIL,
                'status' => '403',
                'message' => 'Pin code does not match.'
            ],
            ExceptionCode::PASSWORD_CONFIRM_FAIL => [
                'code' => (string) ExceptionCode::PASSWORD_CONFIRM_FAIL,
                'status' => '400',
                'message' => 'Password confirmation does not match.'
            ],
            ExceptionCode::UNSPECIFIED_DATA_COLUMN => [
                'code' => (string) ExceptionCode::UNSPECIFIED_DATA_COLUMN,
                'status' => '400',
                'message' => 'Unspecified any data.'
            ],
            ExceptionCode::ACCOUNT_EXISTS => [
                'code' => (string) ExceptionCode::ACCOUNT_EXISTS,
                'status' => '403',
                'message' => 'The account is already registered.'
            ],
            ExceptionCode::PHONE_VERIFYCODE_FAIL => [
                'code' => (string) ExceptionCode::PHONE_VERIFYCODE_FAIL,
                'status' => '403',
                'message' => 'Invalid phone verifycode.'
            ],
            ExceptionCode::PHONE_VERIFYCODE_SEND_FAIL => [
                'code' => (string) ExceptionCode::PHONE_VERIFYCODE_SEND_FAIL,
                'status' => '500',
                'message' => 'Phone verifycode failed to send.'
            ],
            ExceptionCode::PHONE_EXISTS => [
                'code' => (string) ExceptionCode::PHONE_EXISTS,
                'status' => '403',
                'message' => 'The phone is already registered.'
            ],
            ExceptionCode::EMAIL_EXISTS => [
                'code' => (string) ExceptionCode::EMAIL_EXISTS,
                'status' => '403',
                'message' => 'The e-mail is already registered.'
            ],
            ExceptionCode::NICKNAME_EXISTS => [
                'code' => (string) ExceptionCode::NICKNAME_EXISTS,
                'status' => '403',
                'message' => 'The nickname is already registered.'
            ],
            ExceptionCode::PIN_CODE_UNDEFINED => [
                'code' => (string) ExceptionCode::PIN_CODE_UNDEFINED,
                'status' => '403',
                'message' => 'Missing pin code.'
            ],
            ExceptionCode::BANK_ACCOUNT_UNDEFINED => [
                'code' => (string) ExceptionCode::BANK_ACCOUNT_UNDEFINED,
                'status' => '403',
                'message' => 'Missing bank account.'
            ],
        ]
    ]
];
