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
        /* User Admin API */
        Route::group([
            'as' => 'admin.setting.',
            'prefix' => 'admin/setting'
        ], function ($router) {
            Route::get('/user/list', 'Member\UserController@adminList')->name('user.list');
            // Route::post('/user', 'Member\UserController@adminCreate')->name('user.create');
            // Route::get('/user/{id}', 'Member\UserController@adminShow')->name('user.show')->where('id', '[1-9]{1}[0-9]*');
            // Route::put('/user/{id}', 'Member\UserController@adminUpdate')->name('user.update')->where('id', '[1-9]{1}[0-9]*');
        });
        /* User Member API */
        Route::group([
            'as' => 'auth.',
            'prefix' => 'auth'
        ], function ($router) {
            // Login or register a member user account
            Route::post('/login', 'Member\UserController@login')->name('login')->middleware('token.login');
            // Login by member user signature
            Route::post('/signature/login', 'Jwt\AuthController@loginSignature')->name('signature.login')->middleware(['token.login', config('ban.throttle.login'), 'token.ban']);
            // Read member user info
            Route::get('/me', 'Member\AuthController@me')->name('read');
            // Member user change extract password
            Route::match(['put', 'patch'], '/extract/password', 'Member\AuthController@changeExtractPassword')->name('change.extract.password');
            // Member user logout access token
            Route::delete('/logout', 'Jwt\AuthController@logout')->name('logout')->middleware(['token.logout', config('ban.throttle.logout'), 'token.ban']);
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
    /* Lottery Games API */
    Route::group([
        'as' => 'games.lottery.',
        'prefix' => 'games/lottery/',
        // 'middleware' => 'token.login',
    ], function ($router) {
        /* User Admin API */
        Route::group([
            'as' => 'admin.setting.',
            'prefix' => 'admin/setting'
        ], function ($router) {
            // 查看遊戲項目
            Route::get('/game/list', 'LotteryGames\GameSettingController@adminList')->name('game.list');
            Route::post('/game', 'LotteryGames\GameSettingController@adminCreate')->name('game.create');
            Route::get('/game/{id}', 'LotteryGames\GameSettingController@adminShow')->name('game.show')->where('id', '[1-9]{1}[0-9]*');
            Route::put('/game/{id}', 'LotteryGames\GameSettingController@adminUpdate')->name('game.update')->where('id', '[1-9]{1}[0-9]*');
        });
        /* User Member API */
        Route::group([
            'as' => 'query.',
            'prefix' => 'query'
        ], function ($router) {
            // 遊戲介紹
            Route::get('/game/list', 'LotteryGames\GameSettingController@queryGameList')->name('game.list');
        });
        Route::group([
            'as' => '',
            'prefix' => '{gameId}',
            'where' => [
                'gameId' => '[1-9]{1}[0-9]*',
            ],
        ], function ($router) {
            /* User Admin API */
            Route::group([
                'as' => 'admin.setting.',
                'prefix' => 'admin/setting'
            ], function ($router) {
                // 查看各遊戲規則分類
                Route::get('/type/list', 'LotteryGames\GameRuleTypeController@adminList')->name('type.list');
                Route::post('/type', 'LotteryGames\GameRuleTypeController@adminCreate')->name('type.create');
                Route::get('/type/{id}', 'LotteryGames\GameRuleTypeController@adminShow')->name('type.show')->where('id', '[1-9]{1}[0-9]*');
                Route::put('/type/{id}', 'LotteryGames\GameRuleTypeController@adminUpdate')->name('type.update')->where('id', '[1-9]{1}[0-9]*');
                // 查看各遊戲規則
                Route::get('/rule/list', 'LotteryGames\GameRuleController@adminList')->name('rule.list');
                Route::post('/rule', 'LotteryGames\GameRuleController@adminCreate')->name('rule.create');
                Route::get('/rule/{id}', 'LotteryGames\GameRuleController@adminShow')->name('rule.show')->where('id', '[1-9]{1}[0-9]*');
                Route::put('/rule/{id}', 'LotteryGames\GameRuleController@adminUpdate')->name('rule.update')->where('id', '[1-9]{1}[0-9]*');
                // 查看各遊戲開獎號碼
                Route::get('/draw/list', 'LotteryGames\GameDrawController@adminList')->name('draw.list');
                Route::put('/redraw/{id}', 'LotteryGames\GameDrawController@adminRedraw')->name('draw.redraw')->where('id', '[1-9]{1}[0-9]*');
                // 查看下注訂單
                Route::get('/bet/list', 'LotteryGames\GameBetController@adminList')->name('bet.list');
            });
            /* User Member API */
            Route::group([
                'as' => 'bet.',
                'prefix' => 'bet'
            ], function ($router) {
                // 遊戲規則(下注用)
                Route::get('/rule/list', 'LotteryGames\GameRuleController@betRuleList')->name('rule.list');
                // 下注
                Route::post('/order', 'LotteryGames\GameBetController@betOrder')->name('order');
                // 下注
                Route::post('/orders', 'LotteryGames\GameBetController@betOrders')->name('orders');
            });
            Route::group([
                'as' => 'query.',
                'prefix' => 'query'
            ], function ($router) {
                // 遊戲介紹跟規則介紹
                Route::get('/introduction', 'LotteryGames\GameRuleTypeController@queryIntroduction')->name('introduction');
                // 開獎歷史
                Route::get('/history', 'LotteryGames\GameDrawController@queryHistory')->name('history');
                // 我的下注紀錄
                Route::get('/record', 'LotteryGames\GameBetController@queryRecord')->name('record');
            });
        });
    });

    /* Docking Third Service API */
    Route::group([
        'as' => 'third.service.',
        'prefix' => 'third/service'
    ], function ($router) {
        // User api
        Route::group([
            'as' => 'user.',
            'prefix' => 'user'
        ], function ($router) {
            // Docking server login by member user signature
            Route::post('/signature/login', 'ThirdService\FintechController@signatureLogin')->name('signature.login')->middleware('token.login');
        });
        // Receipt api
        Route::group([
            'as' => 'receipt.',
            'prefix' => 'receipt'
        ], function ($router) {
            // 接收單據-加點
            Route::post('/point/import', 'ThirdService\FintechController@pointImport')->name('point.import');
            Route::post('/point/export', 'ThirdService\FintechController@pointExport')->name('point.export');
        });
    });
    // Make some resource API interface routing
    
});

/* Other API Operation Customize Auth Middleware */
Route::group([
    'prefix' => config('ban.version')
], function ($router) {

    // Make some resource API interface routing
});
