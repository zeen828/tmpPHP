<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Signature Authentication Secret
    |--------------------------------------------------------------------------
    |
    | Don't forget to set this in your .env file, as it will be used to sign
    | your tokens. A helper command is provided for this:
    | `php artisan signature:secret`
    |
    | Note: This will be used for Symmetric algorithms only (HMAC),
    |
    */

    'secret' => env('SIGNATURE_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Signature Cache Keep Store
    |--------------------------------------------------------------------------
    |
    | Set storage cache from config cache.php.
    | Must match with one of the application's configured cache "stores".
    |
    | Note: Configure proper cache storage for permanent data.
    |
    */

    'keep_store' => env('SIGNATURE_KEEP_CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Signature Cache Interim Store
    |--------------------------------------------------------------------------
    |
    | Set storage cache from config cache.php.
    | Must match with one of the application's configured cache "stores".
    |
    | Note: Configure proper cache storage for time-sensitive data.
    |
    */

    'interim_store' => env('SIGNATURE_INTERIM_CACHE_STORE', 'redis')
];