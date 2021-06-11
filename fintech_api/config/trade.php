<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Single Maximum Amount
    |--------------------------------------------------------------------------
    |
    | Set to limit the single transaction maximum amount.
    |
    | Defaults to '2147483647'.
    */

    'single_max_amount' => '2147483647',

    /*
    |--------------------------------------------------------------------------
    | Amount Decimal
    |--------------------------------------------------------------------------
    |
    | Set the decimal precision of the amount from 0 ~ 12.
    |
    | Defaults to 0.
    */

    'amount_decimal' => 0,

    /*
     * |--------------------------------------------------------------------------
     * | Account Able Entities Model
     * |--------------------------------------------------------------------------
     * |
     * | Set up a list of available transaction account model.
     * | Command: $php artisan make:currency
     * | Note: The account object only needs to use the trait App\Library\Traits\Entity\Trade\Currency.
     * | Note: The holder must be an auth guards object.
     * | Note: If there is no holder of the configuration, the currency is deemed to be disabled.
     * | 'accountables' =>
     * |    Account type code => [
     * |        'status' => Enabled state true or false,
     * |        'code' => Unique account type id code 1 ~ 99,
     * |        'model' => Unique account model class,
     * |        'holders' => [
     * |            Sourceables target type code list
     * |        ]
     * |    ],
     * | ]
     */

    'accountables' => [
        'gold' => [
            'status' => true,
            'code' => 1,
            'model' => App\Entities\Account\Gold::class,
            'holders' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        //:end-account-generating:
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Target Able Entities Model
     * |--------------------------------------------------------------------------
     * |
     * | Set up a list of available transaction source model.
     * | Command: $php artisan config:add-trade-source 
     * | Note: If the source object is an account holder type, then the currency account type is allowed to operate.
     * | Note: The source object needs to use the trait App\Library\Traits\Entity\Trade\Auth.
     * | Note: The source object does not use the trait App\Library\Traits\Entity\Trade\Currency.
     * | 'sourceables' => [
     * |    Target type code => [
     * |        'status' => Enabled state true or false,
     * |        'code' => Unique source type id code 1 ~ 99,
     * |        'model' => Unique source model class
     * |    ],
     * | ]
     */

    'sourceables' => [
        'system' => [
            'status' => true,
            'code' => 1,
            'model' => App\Entities\Jwt\Auth::class
        ],
        'member' => [
            'status' => true,
            'code' => 2,
            'model' => App\Entities\Member\Auth::class
        ],
        'admin' => [
            'status' => true,
            'code' => 3,
            'model' => App\Entities\Admin\Auth::class
        ],
        //:end-source-generating:
    ],
];
