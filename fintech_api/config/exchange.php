<?php
/* Exchange Billingables From ENV */
$billingables = [];
if ($provider = env('BILLING_STORE_PROVIDER')) {
    $billingables['store'] = $provider;
}
if ($provider = env('BILLING_ATM_PROVIDER')) {
    $billingables['atm'] = $provider;
}
if ($provider = env('BILLING_CREDIT_PROVIDER')) {
    $billingables['credit'] = $provider;
}
if ($provider = env('BILLING_TRANSFER_PROVIDER')) {
    $billingables['transfer'] = $provider;
}

return [

    /*
     * |--------------------------------------------------------------------------
     * | Exchange Billingables
     * |--------------------------------------------------------------------------
     * | Specify the billingables with janitor type code.
     * |
     * | Note: Provider code need to use janitor.php to be configured as belong to 'exchange'.
     * | Note: Billing type code language file to use exchange.php.
     * |
     * | Example:
     * | 'billingables' => [
     * |    Billing type code => Provider code
     * | ]
     * |
     */
    
    'billingables' => $billingables,

    /*
     * |--------------------------------------------------------------------------
     * | Billing Link Valid Time Default
     * |--------------------------------------------------------------------------
     * | Specify the length of time (in minutes) that the authcode will be valid for cache.
     * |
     * | Defaults to 5 minutes.
     * | 'billing_link_ttl' => 5
     */

    'billing_link_ttl' => env('BILLING_LINK_TTL', 5),

    /*
     * |--------------------------------------------------------------------------
     * | Minimum Manual Billing Amount
     * |--------------------------------------------------------------------------
     * | Specify the minimum manual billing amount.
     * |
     */

    'min_manual_billing_amount' => 1000,
    
    /*
     * |--------------------------------------------------------------------------
     * | Maximum Manual Billing Amount
     * |--------------------------------------------------------------------------
     * | Specify the maximum manual billing amount.
     * |
     */

    'max_manual_billing_amount' => 1000000,

    /*
     * |--------------------------------------------------------------------------
     * | Minimum Withdraw Amount
     * |--------------------------------------------------------------------------
     * | Specify the minimum withdrawal amount.
     * |
     */

    'min_withdraw_amount' => 1000,
    
    /*
     * |--------------------------------------------------------------------------
     * | Maximum Withdraw Amount
     * |--------------------------------------------------------------------------
     * | Specify the maximum withdrawal amount.
     * |
     */

    'max_withdraw_amount' => 1000000,

];
