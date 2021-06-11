<?php
return [

    /*
     |--------------------------------------------------------------------------
     | Guest Able Class
     |--------------------------------------------------------------------------
     |
     | Usage: App\Libraries\Instances\Router\Janitor class
     | Set up a list of available guest items.
     | Command: $php artisan config:add-janitor-guest
     |
     | Example :
     | Type code => [
     |    'belong' => The value cannot be empty and needs to belong to a specific category,
     |    'status' => Enabled state true or false,
     |    'class' => Unique class name,
     |    'data' => [
     |          // You can attach custom item data
     |    ]
     | ],
     */

    'bet' => [
        'belong' => 'business',
        'status' => env('JANITOR_BET_ENABLE', false),
        'class' => App\Http\Controllers\Business\BetThirdController::class,
        'data' => [
            'client_id' => env('JANITOR_BET_CLIENT_ID'),
            'client_secret' => env('JANITOR_BET_CLIENT_SECRET'),
            'login_cell' => App\Libraries\Cells\Service\Business\LoginCell::class,
            'login_url' => env('JANITOR_BET_LOGIN_URL'), // 授權登入網址，使用 {code} 填充授權碼
            "banner" => "https://www.bet.com/banner.jpg",
            'website' => 'https://www.bet.com',
            'invite_cell' => App\Libraries\Cells\Service\Business\InviteCell::class,
            'invite_url' => env('JANITOR_BET_INVITE_URL'), // 授權邀請網址，使用 {code} 填充授權碼
            'invite_ttl' => 60, // 邀請授權碼，有效分鐘數
            'available_invite' => (env('JANITOR_BET_INVITE_URL') ? true : false), // 可用邀請 (true | false)
            // You can attach custom item data
        ]
    ],
    'binary' => [
        'belong' => 'business',
        'status' => env('JANITOR_BINARY_ENABLE', false),
        'class' => App\Http\Controllers\Business\BinaryThirdController::class,
        'data' => [
            'client_id' => env('JANITOR_BINARY_CLIENT_ID'),
            'client_secret' => env('JANITOR_BINARY_CLIENT_SECRET'),
            'login_cell' => App\Libraries\Cells\Service\Business\LoginCell::class,
            'login_url' => env('JANITOR_BINARY_LOGIN_URL'), // 授權登入網址，使用 {code} 填充授權碼
            "banner" => "https://www.binary.com/banner.jpg",
            'website' => 'https://www.binary.com',
            'invite_cell' => App\Libraries\Cells\Service\Business\InviteCell::class,
            'invite_url' => env('JANITOR_BINARY_INVITE_URL'), // 授權邀請網址，使用 {code} 填充授權碼
            'invite_ttl' => 60, // 邀請授權碼，有效分鐘數
            'available_invite' => (env('JANITOR_BINARY_INVITE_URL') ? true : false), // 可用邀請 (true | false)
            // You can attach custom item data
        ]
    ],
    'payday' => [
        'belong' => 'exchange',
        'status' => env('JANITOR_PAYDAY_ENABLE', false),
        'class' => App\Http\Controllers\Exchange\PaydayThirdController::class,
        'data' => [
            'client_id' =>  env('JANITOR_PAYDAY_CLIENT_ID'),
            'client_secret' => env('JANITOR_PAYDAY_CLIENT_SECRET'),
            'api_url' => env('JANITOR_PAYDAY_API_URL'), // 服務 API 網址
            'billing_url' => env('JANITOR_PAYDAY_BILLING_URL'), // 授權支付網址，使用 {code} 填充授權碼
            // 類型最小金額
            'billing_min_amount' => [
                'store' => 100,
                'atm' => 100,
                'credit' => 100,
                'transfer' => 100,
            ],
            // 類型最大金額
            'billing_max_amount' => [
                'store' => 6000,
                'atm' => 6000,
                'credit' => 6000,
                'transfer' => 6000,
            ],
            'notify_url' => env('JANITOR_PAYDAY_NOTIFY_URL'), // 完成通知網址
            'payment_url' => env('JANITOR_PAYDAY_PAYMENT_URL'), // 取號通知網址
            'return_url' => env('JANITOR_PAYDAY_RETURN_URL', 'http://example.com'), // 完成返回網址
            'bank_code' => env('JANITOR_PAYDAY_BANK_CODE'), // 銀行代碼
            'branch_code' =>  env('JANITOR_PAYDAY_BRANCH_CODE'), // 銀行分行代碼
            'bank_account' => env('JANITOR_PAYDAY_BANK_ACCOUNT'), // 銀行帳號
            'account_name' => env('JANITOR_PAYDAY_ACCOUNT_NAME'), // 銀行戶名
            // You can attach custom item data
        ]
    ],
    //:end-generating:
];