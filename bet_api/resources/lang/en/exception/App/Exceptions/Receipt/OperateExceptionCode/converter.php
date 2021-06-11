<?php
use App\Exceptions\Receipt\OperateExceptionCode as ExceptionCode;
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
            ExceptionCode::FORMDEFINE_UNDEFINED => [
                'code' => (string) ExceptionCode::FORMDEFINE_UNDEFINED,
                'status' => '403',
                'message' => 'Unauthorized form type.'
            ],
            ExceptionCode::SOURCEABLE_UNDEFINED => [
                'code' => (string) ExceptionCode::SOURCEABLE_UNDEFINED,
                'status' => '403',
                'message' => 'Unauthorized operation source type.'
            ],
            ExceptionCode::NON_PERMITTED_FORM_OBJECT => [
                'code' => (string) ExceptionCode::NON_PERMITTED_FORM_OBJECT,
                'status' => '403',
                'message' => 'Non-permitted form object.'
            ],
            ExceptionCode::UNKNOWN_OBJECT_FROM_SOURCEABLE => [
                'code' => (string) ExceptionCode::UNKNOWN_OBJECT_FROM_SOURCEABLE,
                'status' => '403',
                'message' => 'Unknown operation source object.'
            ],
            ExceptionCode::UNKNOWN_ORDER_FROM_PARENT => [
                'code' => (string) ExceptionCode::UNKNOWN_ORDER_FROM_PARENT,
                'status' => '403',
                'message' => 'Unknown order from parent order.'
            ],
            ExceptionCode::SOURCE_OPERATION_DISABLED => [
                'code' => (string) ExceptionCode::SOURCE_OPERATION_DISABLED,
                'status' => '403',
                'message' => 'Source operation has been disabled.'
            ],
        ]
    ]
];
