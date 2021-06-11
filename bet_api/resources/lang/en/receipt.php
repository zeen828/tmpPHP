<?php
return [
    
    /*
     * |--------------------------------------------------------------------------
     * | Receipt Action Memo Content
     * |--------------------------------------------------------------------------
     * |
     * | Set the receipt content relative name list.
     * | 'memo' => [
     * |    'content' => [
     * |        Content type description => Display content
     * |    ],
     * |    // Other tag
     * | ]
     */
    'memo' => [
        'content' => [
            //
        ],
        // Other tag
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Receipt Form Type Name
     * |--------------------------------------------------------------------------
     * |
     * | Set the receipt form type relative name list.
     * | 'formdefines' => [
     * |    Form type code => Type name
     * | ]
     */
    'formdefines' => [
        'billing' => 'Billing',
        'payment' => 'Payment',
        'deposit' => 'Deposit'
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Receipt Target Type Name
     * |--------------------------------------------------------------------------
     * |
     * | Set the receipt source type relative name list.
     * | 'sourceables' => [
     * |    Target type code => Type name
     * | ]
     */
    'sourceables' => [
        'system' => 'System',
        'member' => 'Member',
        'admin' => 'Admin'
    ],
];
