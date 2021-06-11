<?php
use App\Exceptions\LotteryGames\GameBetExceptionCode as ExceptionCode;
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
            ExceptionCode::NOT_EXIST => [
                'code' => (string) ExceptionCode::NOT_EXIST,
                'status' => '401',
                'message' => 'Game lottery bet does not exist.'
            ], 
            ExceptionCode::NOT_ENOUGH_POINT => [
                'code' => (string) ExceptionCode::NOT_ENOUGH_POINT,
                'status' => '401',
                'message' => 'Not enough points required to play the game.'
            ], 
            ExceptionCode::WRONG_BET_VALUE => [
                'code' => (string) ExceptionCode::WRONG_BET_VALUE,
                'status' => '401',
                'message' => 'The betting information is incorrect.'
            ], 
            ExceptionCode::CANNOT_BET_TODAY => [
                'code' => (string) ExceptionCode::CANNOT_BET_TODAY,
                'status' => '401',
                'message' => 'Cannot place bets today.'
            ], 
        ]
    ]
];
