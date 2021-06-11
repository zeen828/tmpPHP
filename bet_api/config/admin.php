<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Logon Auth Redirect Url
    |--------------------------------------------------------------------------
    |
    | Set the redirect uri for the administrator logon authentication email.
    |
    */

    'logon_redirect' => env('ADMIN_LOGON_REDIRECT', 'http://example.com'),

    /*
    |--------------------------------------------------------------------------
    | Admin Logon Auth Redirect Uri Query Variable
    |--------------------------------------------------------------------------
    |
    | Set the redirect uri query variable name for the administrator logon authentication email.
    |
    | Defaults : auth
    */

    'logon_redirect_query_var' => 'auth',

    /*
    |--------------------------------------------------------------------------
    | Resend Admin Auth Redirect Url
    |--------------------------------------------------------------------------
    |
    | Set the redirect uri for the administrator to resend the authentication email.
    |
    */

    'resend_auth_redirect' => env('ADMIN_RESEND_AUTH_REDIRECT', 'http://example.com'),

    /*
    |--------------------------------------------------------------------------
    | Resend Admin Auth Redirect Uri Query Variable
    |--------------------------------------------------------------------------
    |
    | Set the redirect uri query variable name for the administrator to resend the authentication email.
    |
    | Defaults : auth
    */

    'resend_auth_redirect_query_var' => 'auth',
];
