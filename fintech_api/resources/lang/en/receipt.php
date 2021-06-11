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
            'Billing request.' => 'Billing request.',
            'Notify to payment.' => 'Notify to payment.',
            'Deposit finish.' => 'Deposit finish.',
            'Interruption of billing.' => 'Interruption of billing.',
            'Payment interrupted.' => 'Payment interrupted.',
            'Deposit interrupted.' => 'Deposit interrupted.',
            'Request for withdrawal.' => 'Request for withdrawal.',
            'Notify to remittance.' => 'Notify to remittance.',
            'Remittance finish.' => 'Remittance finish.',
            'Withdrawal interrupted.' => 'Withdrawal interrupted.',
            'Remittance interrupted.' => 'Remittance interrupted.',
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
        'deposit' => 'Deposit',
        'interrupt' => 'Interrupt',
        'manual_billing' => 'Manual Billing',
        'manual_payment' => 'Manual Payment',
        'manual_deposit' => 'Manual Deposit',
        'manual_interrupt' => 'Manual Interrupt',
        'withdraw_deposit' => 'Withdraw Deposit',
        'remittance' => 'Remittance',
        'remittance_finish' => 'Remittance Finish',
        'withdraw_interrupt' => 'Withdraw Interrupt',
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
