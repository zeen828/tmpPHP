<?php
return [

    /*
     * |--------------------------------------------------------------------------
     * | Form Define
     * |--------------------------------------------------------------------------
     * |
     * | Set up a list of available receipt form items.
     * | Command: $php artisan config:add-receipt-form
     * | Note: The editor must be an auth guards object.
     * | Note: If there is no editor of the configuration, the receipt is deemed to be disabled.
     * | 'formdefines' =>
     * |    Form type code => [
     * |        'status' => Enabled state true or false,
     * |        'code' => Unique form type id code 1 ~ 99,
     * |        'editors' => [
     * |            Sourceables target type code list
     * |        ]
     * |    ],
     * | ]
     */

    'formdefines' => [
        'billing' => [
            'status' => true,
            'code' => 1,
            'editors' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        'payment' => [
            'status' => true,
            'code' => 2,
            'editors' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        'deposit' => [
            'status' => true,
            'code' => 3,
            'editors' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        'interrupt' => [
            'status' => true,
            'code' => 4,
            'editors' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        'manual_billing' => [
            'status' => true,
            'code' => 5,
            'editors' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        'manual_payment' => [
            'status' => true,
            'code' => 6,
            'editors' => [
                'admin',
                // Set sourceables target type code
            ]
        ],
        'manual_deposit' => [
            'status' => true,
            'code' => 7,
            'editors' => [
                'admin',
                // Set sourceables target type code
            ]
        ],
        'manual_interrupt' => [
            'status' => true,
            'code' => 8,
            'editors' => [
                'member',
                'admin',
                // Set sourceables target type code
            ]
        ],
        'withdraw_deposit' => [
            'status' => true,
            'code' => 9,
            'editors' => [
                'member',
                // Set sourceables target type code
            ]
        ],
        'remittance' => [
            'status' => true,
            'code' => 10,
            'editors' => [
                'admin',
                // Set sourceables target type code
            ]
        ],
        'remittance_finish' => [
            'status' => true,
            'code' => 11,
            'editors' => [
                'admin',
                // Set sourceables target type code
            ]
        ],
        'withdraw_interrupt' => [
            'status' => true,
            'code' => 12,
            'editors' => [
                'member',
                'admin',
                // Set sourceables target type code
            ]
        ],
        //:end-form-generating:
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Target Able Entities Model
     * |--------------------------------------------------------------------------
     * |
     * | Set the list of available receipt operation source models.
     * | Command: $php artisan config:add-receipt-source
     * | Note: The source object needs to use the trait App\Library\Traits\Entity\Receipt\Auth.
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
