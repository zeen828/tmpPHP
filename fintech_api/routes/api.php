<?php

use Illuminate\Http\Request;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 * |--------------------------------------------------------------------------
 * | API Note
 * |--------------------------------------------------------------------------
 * | 1.The specified throttle middleware must have a type name and cannot be empty.
 * |
 * | 2.Only the route name definition can be a valid description interface.
 * |
 * | 3.Auth API Operation : Used middleware "token.auth".
 * |
 * | 4.Make good use of request protection middleware "throttle:?,?" by ban.php config.
 * |
 * | 5.Open API Operation : No middleware "token.ban".
 * |
 * | 6.Through ban.php configuration, make the API version use "ban.version".
 * |
 */

/* Customize API Operation */
Route::group([
    'middleware' => [config('ban.throttle.base'), 'token.auth', 'token.ban'],
    'prefix' => config('ban.version')
], function ($router) {
    /* Admin API */
    Route::group([
        'as' => 'admin.',
        'prefix' => 'admin'
    ], function ($router) {
        /* Admin Auth API */
        Route::group([
            'as' => 'auth.',
            'prefix' => 'auth'
        ], function ($router) {
            /* Get user self info */
            Route::get('/me', 'Admin\AuthController@me')->name('read');
            /* Put user profile */
            Route::match(['put', 'patch'], '/profile', 'Admin\AuthController@editProfile')->name('edit.profile');
            /* Put user password */
            Route::patch('/password', 'Admin\AuthController@changePassword')->name('change.password');
        });
        /* Admin User API */
        Route::group([
            'middleware' => 'request.admin.uid',
            'as' => 'user.',
            'prefix' => 'user'
        ], function ($router) {
            /* Logon admin and send auth mail */
            Route::post('/logon', 'Admin\UserController@logon')->name('logon');
            /* Resend auth mail */
            Route::post('/resend/auth/{uid}', 'Admin\UserController@resendAuthMail')->name('resend.auth')->where('uid', '[1-9]{1}[0-9]*');
            /* Get admin user index */
            Route::get('/', 'Admin\UserController@index')->name('index');
            /* Get admin user info */
            Route::get('/{uid}', 'Admin\UserController@read')->name('read')->where('uid', '[1-9]{1}[0-9]*');
            /* Disable admin service */
            Route::patch('/disable/{uid}', 'Admin\UserController@disable')->name('disable')->where('uid', '[1-9]{1}[0-9]*');
            /* Enable admin service */
            Route::patch('/enable/{uid}', 'Admin\UserController@enable')->name('enable')->where('uid', '[1-9]{1}[0-9]*');
        });
    });
    /* Member API */
    Route::group([
        'as' => 'member.',
        'prefix' => 'member'
    ], function ($router) {
        /* Update terms timestamp */
        Route::patch('/terms/touch', 'Member\UserController@touchTermsTimestamp')->name('terms.touch');
        /* Admin Auth API */
        Route::group([
            'as' => 'auth.',
            'prefix' => 'auth'
        ], function ($router) {
            /* Get user self info */
            Route::get('/me', 'Member\AuthController@me')->name('read');
            /* Put user agree status */
            Route::patch('/agree', 'Member\AuthController@agree')->name('agree');
            /* Put user password */
            Route::patch('/password', 'Member\AuthController@changePassword')->name('change.password');
            /* Put user pin code */
            Route::patch('/pin', 'Member\AuthController@changePin')->name('change.pin');
            /* Put user profile */
            Route::match(['put', 'patch'], '/profile', 'Member\AuthController@editProfile')->name('edit.profile');
            /* Put user setting */
            Route::match(['put', 'patch'], '/setting', 'Member\AuthController@editSetting')->name('edit.setting');
        });
        /* Member User API */
        Route::group([
            'middleware' => 'request.member.uid',
            'as' => 'user.',
            'prefix' => 'user'
        ], function ($router) {
            /* Get admin user index */
            Route::get('/', 'Member\UserController@index')->name('index');
            /* Get admin user info */
            Route::get('/{uid}', 'Member\UserController@read')->name('read')->where('uid', '[1-9]{1}[0-9]*');
            /* Disable admin service */
            Route::patch('/disable/{uid}', 'Member\UserController@disable')->name('disable')->where('uid', '[1-9]{1}[0-9]*');
            /* Enable admin service */
            Route::patch('/enable/{uid}', 'Member\UserController@enable')->name('enable')->where('uid', '[1-9]{1}[0-9]*');
        });
    });
    /* Trade API */
    Route::group([
        'as' => 'trade.',
        'prefix' => 'trade'
    ], function ($router) {
         /* Trade Currency API */
         Route::group([
            'as' => 'currency.',
            'prefix' => 'currency'
        ], function ($router) {
            /* All currency types */
            Route::get('/type', 'Trade\CurrencyController@currencyTypes')->name('types');
            /* My currency types */
            Route::get('/type/my', 'Trade\CurrencyController@myCurrencyTypes')->name('types.my');
            /* Trade Currency Account API */
            Route::group([
                'as' => 'account.',
                'prefix' => 'account'
            ], function ($router) {
                /* Get currency all account index */
                Route::get('/{type}', 'Trade\CurrencyController@index')->middleware(['request.currency.type'])->name('index')->where('type', '[a-zA-Z0-9_]+');
                /* Get specify currency account info */
                Route::get('/{type}/{account}', 'Trade\CurrencyController@read')->middleware(['request.currency.type', 'request.currency.typeaccount'])->name('read')->where(['type' => '[a-zA-Z0-9_]+', 'account' => '[1-9]{1}[0-9]*']);
                /* Get user account info */
                Route::get('/{type}/my', 'Trade\CurrencyController@my')->middleware(['request.currency.type'])->name('my')->where('type', '[a-zA-Z0-9_]+');
            });
        });
        /* Trade Log API */
        Route::group([
            'middleware' => 'pause.trade.service',
            'as' => 'log.',
            'prefix' => 'log'
        ], function ($router) {
            /* Get all trade log index */
            Route::get('/', 'Trade\LogController@index')->name('index');
            /* Get all trade log index for account currency */
            Route::get('/currency/{type}', 'Trade\LogController@currencyIndex')->middleware(['request.currency.type'])->name('currency.index')->where('type', '[a-zA-Z0-9_]+');
            /* Get trade order info */
            Route::get('/{order}', 'Trade\LogController@read')->name('read')->where('order', '[1-9]{1}[0-9]*');
            /* Get user trade log index */
            Route::get('/my', 'Trade\LogController@my')->name('my');
            /* Get user trade log index for account currency */
            Route::get('/currency/{type}/my', 'Trade\LogController@currencyMy')->middleware(['request.currency.type'])->name('currency.my')->where('type', '[a-zA-Z0-9_]+');
            /* Get user trade order info */
            Route::get('/my/{order}', 'Trade\LogController@myOrder')->name('my.order')->where('order', '[1-9]{1}[0-9]*');
        });
    });
    /* Receipt API */
    Route::group([
        'as' => 'receipt.',
        'prefix' => 'receipt'
    ], function ($router) {
        /* Receipt Form API */
        Route::group([
            'as' => 'form.',
            'prefix' => 'form'
        ], function ($router) {
            /* All form types */
            Route::get('/type', 'Receipt\FormController@formTypes')->name('types');
            /* My form types */
            Route::get('/type/my', 'Receipt\FormController@myFormTypes')->name('types.my');
            /* Receipt Form Data API */
            Route::group([
                'as' => 'data.',
                'prefix' => 'data'
            ], function ($router) {
                /* Get form data index */
                Route::get('/{type}', 'Receipt\FormController@index')->middleware(['request.receipt.type'])->name('index')->where('type', '[a-zA-Z0-9_]+');
                /* Get user form data index */
                Route::get('/{type}/my', 'Receipt\FormController@my')->middleware(['request.receipt.type'])->name('my')->where('type', '[a-zA-Z0-9_]+');
            });
        });
        /* Receipt Log API */
        Route::group([
            'as' => 'log.',
            'prefix' => 'log'
        ], function ($router) {
            /* Get receipt log index */
            Route::get('/', 'Receipt\LogController@index')->name('index');
            /* Get receipt order info */
            Route::get('/{order}', 'Receipt\LogController@read')->name('read')->where('order', '[1-9]{1}[0-9]*');
            /* Get receipt order main info */
            Route::get('/{order}/main', 'Receipt\LogController@readMain')->name('read.main')->where('order', '[1-9]{1}[0-9]*');
            /* Get receipt order last info */
            Route::get('/{order}/last', 'Receipt\LogController@readLast')->name('read.last')->where('order', '[1-9]{1}[0-9]*');
            /* Get user receipt log index */
            Route::get('/my', 'Receipt\LogController@my')->name('my');
            /* Get user receipt order info */
            Route::get('/my/{order}', 'Receipt\LogController@myOrder')->name('my.order')->where('order', '[1-9]{1}[0-9]*');
            /* Get user receipt order main info */
            Route::get('/my/{order}/main', 'Receipt\LogController@myOrderMain')->name('my.order.main')->where('order', '[1-9]{1}[0-9]*');
            /* Get user receipt order last info */
            Route::get('/my/{order}/last', 'Receipt\LogController@myOrderLast')->name('my.order.last')->where('order', '[1-9]{1}[0-9]*');
        });
    });
    /* Business API */
    Route::group([
        'as' => 'business.',
        'prefix' => 'business'
    ], function ($router) {
        /* Get service index */
        Route::get('/', 'Business\ServiceController@index')->name('index');
        /* Lgoin link */
        Route::post('/auth/link', 'Business\ServiceController@authLink')->name('auth.link');
        /* Invite link */
        Route::post('/invite/link', 'Business\ServiceController@inviteLink')->name('invite.link');
        /* Invite auth */
        Route::post('/invite/auth', 'Business\ServiceController@inviteAuth')->name('invite.auth');
    });
    /* Exchange API */
    Route::group([
        'as' => 'exchange.',
        'prefix' => 'exchange'
    ], function ($router) {
        /* Exchange Billing API */
        Route::group([
            'as' => 'billing.',
            'prefix' => 'billing'
        ], function ($router) {
            /* Billing types */
            Route::get('/type', 'Exchange\ServiceController@billingTypes')->name('types');
            /* Billing link */
            Route::post('/link', 'Exchange\ServiceController@billingLink')->name('link');
        });
        /* Exchange Manual API */
        Route::group([
            'as' => 'manual.',
            'prefix' => 'manual'
        ], function ($router) {
            /* Billing */
            Route::post('/billing', 'Exchange\ServiceController@manualBilling')->name('billing');
            /* Payment */
            Route::post('/payment/{order}', 'Exchange\ServiceController@manualPayment')->name('payment')->where('order', '[1-9]{1}[0-9]*');
            /* Deposit */
            Route::post('/deposit/{order}', 'Exchange\ServiceController@manualDeposit')->name('deposit')->where('order', '[1-9]{1}[0-9]*');
            /* Interrupt */
            Route::post('/interrupt/{order}', 'Exchange\ServiceController@manualInterrupt')->name('interrupt')->where('order', '[1-9]{1}[0-9]*');
        });
        /* Exchange Manual API */
        Route::group([
            'as' => 'withdraw.',
            'prefix' => 'withdraw'
        ], function ($router) {
            /* Start */
            Route::post('/deposit', 'Exchange\ServiceController@withdrawDeposit')->name('deposit');
            /* To Remittance */
            Route::post('/remittance/{order}', 'Exchange\ServiceController@remittance')->name('remittance')->where('order', '[1-9]{1}[0-9]*');
            /* Remittance Finish */
            Route::post('/finish/{order}', 'Exchange\ServiceController@remittanceFinish')->name('finish')->where('order', '[1-9]{1}[0-9]*');
            /* Interrupt Withdraw */
            Route::post('/cancel/{order}', 'Exchange\ServiceController@cancelWithdraw')->name('cancel')->where('order', '[1-9]{1}[0-9]*');
        });
    });
    
    // Make some resource API interface routing
    
});

/* Other API Operation Customize Auth Middleware */
Route::group([
    'prefix' => config('ban.version')
], function ($router) {
    /* Member API */
    Route::group([
        'as' => 'member.',
        'prefix' => 'member'
    ], function ($router) {
        /* Member Auth API */
        Route::group([
            'as' => 'auth.',
            'prefix' => 'auth'
        ], function ($router) {
            /* Logon user */
            Route::post('/logon', 'Member\AuthController@logon')->middleware([config('ban.throttle.logon'), 'token.login', 'token.ban'])->name('logon');
            /* Phone verify code */
            Route::post('/verifycode', 'Member\AuthController@verifyCode')->middleware([config('ban.throttle.verifycode'), 'token.auth', 'token.ban'])->name('verifycode');
            /* Phone Login */
            Route::post('/phone/login', 'Member\AuthController@phoneLogin')->middleware([config('ban.throttle.login'), 'token.login', 'token.ban'])->name('phone.login');
        });
    });
    
    // Make some resource API interface routing
});
