<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


/* Exchange API */
Route::group([
    'as' => 'exchange.',
    'prefix' => 'exchange'
], function ($router) {
    /* Exchange Payday API */
    Route::group([
        'as' => 'payday.',
        'prefix' => 'payday'
    ], function ($router) {
        /* Billing */
        Route::get('/billing/{code}', 'Exchange\PaydayThirdController@billing')->name('billing')->where('code', '(.){72}');
        /* Payment */
        Route::post('/payment', 'Exchange\PaydayThirdController@payment')->name('payment');
        /* Deposit */
        Route::post('/deposit', 'Exchange\PaydayThirdController@deposit')->name('deposit');
    });
});
/* Business API */
Route::group([
    'as' => 'business.',
    'prefix' => 'business'
], function ($router) {
    /* Bet API */
    Route::group([
        'as' => 'bet.',
        'prefix' => 'bet'
    ], function ($router) {
        /* User auth profile */
        Route::get('/profile/{signature}', 'Business\BetThirdController@profile')->name('profile')->where('signature', '(.){72}');
    });
    /* Binary API */
    Route::group([
        'as' => 'binary.',
        'prefix' => 'binary'
    ], function ($router) {
        /* User auth profile */
        Route::get('/profile/{signature}', 'Business\BinaryThirdController@profile')->name('profile')->where('signature', '(.){72}');
    });
});
