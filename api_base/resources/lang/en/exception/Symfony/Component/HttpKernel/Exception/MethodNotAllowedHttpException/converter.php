<?php
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
        'code' => '0',
        'status' => '405',
        'message' => 'Method not allowed.'
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
            0 => [
                'code' => '0',
                'status' => '405',
                'message' => 'Method not allowed.'
            ],
        ],
        405 => [
            0 => [
                'code' => '0',
                'status' => '405',
                'message' => 'Method not allowed.'
            ],
        ],
    ]
];
