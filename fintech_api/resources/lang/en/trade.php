<?php
return [
    
    /*
     * |--------------------------------------------------------------------------
     * | Transaction Action Memo Content
     * |--------------------------------------------------------------------------
     * |
     * | Set the trading content relative name list.
     * | 'memo' => [
     * |    'content' => [
     * |        Content type description => Display content
     * |    ],
     * |    // Other tag
     * | ]
     */
    'memo' => [
        'content' => [
            'Income deposit.' => 'Income deposit.',
            'Make a withdrawal.' => 'Make a withdrawal.',
            'Income due to cancellation of withdrawal.' => 'Income due to cancellation of withdrawal.',
        ],
        // Other tag
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Transaction Account Type Name
     * |--------------------------------------------------------------------------
     * |
     * | Set the trading account type relative name list.
     * | 'accountables' => [
     * |    Account type code => Type name
     * | ]
     */
    'accountables' => [
        'gold' => 'Gold',
        //
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Transaction Target Type Name
     * |--------------------------------------------------------------------------
     * |
     * | Set the trading source type relative name list.
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
