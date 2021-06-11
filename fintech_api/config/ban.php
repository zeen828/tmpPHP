<?php
return [

    /*
     |--------------------------------------------------------------------------
     | API Resource Version
     |--------------------------------------------------------------------------
     |
     | Example :
     | 'version' => 'v1'
     */
    
    'version' => env('API_VERSION', 'v1'),

    /*
     |--------------------------------------------------------------------------
     | API Throttle Whitelisted IP
     |--------------------------------------------------------------------------
     |
     | Set the APIs throttle whitelisted IP list.
     |
     | Example :
     | 'throttle_whitelisted' => [
     |    Whitelisted IPs
     | ]
     */

    'throttle_whitelisted' => [
        '::1',
        '127.0.0.1',
        '211.20.117.250',
    ],

    /*
     |--------------------------------------------------------------------------
     | API Throttle Limit
     |--------------------------------------------------------------------------
     |
     | Set the APIs throttle limit fornat : [throttle:request count limit, request interval minute limit, type name].
     | Note: When interval minutes is 0, it is unlimited.
     |
     | Example :
     | 'throttle' => [
     |    Type name => 'throttle:60,1,Type name',
     | ]
     */

    'throttle' => [
        'auth' => 'throttle:' . env('ALLOW_AUTH_API_REQUESTS', 30) . ',' . env('AUTH_API_REQUEST_WAIT_MINUTES', 1) . ',auth',
        'base' => 'throttle:' . env('ALLOW_BASE_API_REQUESTS', 60) . ',' . env('BASE_API_REQUEST_WAIT_MINUTES', 1) . ',base',
        'login' => 'throttle:' . env('ALLOW_USER_LOGIN_API_REQUESTS', 9) . ',' . env('USER_LOGIN_API_REQUEST_WAIT_MINUTES', 3) . ',login',
        'logon' => 'throttle:' . env('ALLOW_USER_LOGON_API_REQUESTS', 6) . ',' . env('USER_LOGON_API_REQUEST_WAIT_MINUTES', 3) . ',logon',
        'forget_password' => 'throttle:' . env('ALLOW_USER_FORGET_PASSWORD_API_REQUESTS', 6) . ',' . env('USER_FORGET_PASSWORD_API_REQUEST_WAIT_MINUTES', 3) . ',forget_password',
        'logout' => 'throttle:' . env('ALLOW_USER_LOGOUT_API_REQUESTS', 6) . ',' . env('USER_LOGOUT_API_REQUEST_WAIT_MINUTES', 3) . ',logout',
        'verifycode' => 'throttle:' . env('ALLOW_VERIFYCODE_API_REQUESTS', 5) . ',' . env('VERIFYCODE_API_REQUEST_WAIT_MINUTES', 3) . ',verifycode',
    ],

    /*
     |--------------------------------------------------------------------------
     | Ignore Restrict Access
     |--------------------------------------------------------------------------
     |
     | Set the APIs to ignore the restricted access of access guards.
     |
     | Example :
     | 'ignore_restrict_access' => [
     |     Allow API named route to ignore restricted access
     | ]
     */

    'ignore_restrict_access' => [
        'auth.user.types',
        'auth.read.service',
        'auth.token.revoke',
        'auth.token.refresh',
    ],

    /*
     |--------------------------------------------------------------------------
     | Release Service Ban
     |--------------------------------------------------------------------------
     |
     | List of client service bans.
     | Forbidden and restricted use of client services is specified by an API named route.
     | Client service bans are unique serial number.
     | Controlled by middleware 'token.ban' .
     | Description file : (resources/lang/ language dir /ban.php)
     | Command: $php artisan config:add-ban-service
     |
     | Example :
     | 'release' => [
     |    Ban number => [
     |        'description' => Description code project,
     |        'restrict_access_guards' => Auth guards type array to restrict access (Ignored if using routing middleware "token.login" or in the configuration "ban.ignore_restrict_access"),
     |        'unique_auth_ignore_guards' => Auth guards type array to ignore unique auth column in the auth table,
     |        'unique_auth_inherit_login_guards' => Auth guards type array can inherit login from the unique auth column in the auth table,
     |        'status' => Available option status ( TRUE | FALSE ),
     |        'allow_named' => [
     |           Allow API named route or * all are allowed
     |        ],
     |        'unallow_named' => [
     |           Unallow API named route or * all are not allowed
     |        ]
     |    ],
     | ]
     */

    'release' => [
        0 => [
            'description' => 'global',
            'restrict_access_guards' => [],
            'unique_auth_ignore_guards' => [],
            'unique_auth_inherit_login_guards' => [],
            'status' => false,
            'allow_named' => [
                '*'
            ],
            'unallow_named' => []
        ],
        1 => [
            'description' => 'admin',
            'restrict_access_guards' => [
                'admin'
            ],
            'unique_auth_ignore_guards' => [
                'client'
            ],
            'unique_auth_inherit_login_guards' => [],
            'status' => true,
            'allow_named' => [
                '*'
            ],
            'unallow_named' => [
                'member.auth.*',
                'trade.log.my',
                'trade.log.my.order',
                'trade.log.currency.my',
                'trade.currency.account.my',
                'receipt.log.my',
                'receipt.log.my.*',
                'receipt.form.data.my',
            ]
        ],
        2 => [
            'description' => 'member',
            'restrict_access_guards' =>  [
                'member'
            ],
            'unique_auth_ignore_guards' => [
                'client'
            ],
            'unique_auth_inherit_login_guards' => [],
            'status' => true,
            'allow_named' => [
                '*'
            ],
            'unallow_named' => [
                'auth.client.*',
                'system.parameter.*',
                'system.interface.*',
                'system.authority.*',
                'system.log.types',
                'system.log.index',
                'notice.bulletin.build',
                'notice.bulletin.disable',
                'notice.bulletin.enable',
                'sms.log.*',
                'admin.*',
                'member.user.*',
                'member.terms.touch',
                'trade.log.index',
                'trade.log.read',
                'trade.log.currency.index',
                'trade.currency.account.index',
                'trade.currency.account.read',
                'receipt.log.index',
                'receipt.log.read',
                'receipt.log.read.*',
                'receipt.form.data.index',
            ]
        ],
        3 => [
            'description' => 'business',
            'restrict_access_guards' =>  [
                'client',
                'member'
            ],
            'unique_auth_ignore_guards' => [
                'client',
                'member'
            ],
            'unique_auth_inherit_login_guards' => [
                'member'
            ],
            'status' => true,
            'allow_named' => [
                'auth.user.logout',
                'auth.user.signature.login',
                'auth.read.service',
                'auth.token.create',
                'auth.token.revoke',
                'auth.token.refresh',
            ],
            'unallow_named' => []
        ],
        //:end-generating:
    ]
];
