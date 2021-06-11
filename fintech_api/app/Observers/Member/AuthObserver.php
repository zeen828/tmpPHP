<?php

namespace App\Observers\Member;

use App\Entities\Member\Auth as Auth;
use Cache;
use TokenAuth;

/**
 * Class AuthObserver.
 *
 * @package App\Observers\Member
 */
class AuthObserver
{
    /**
     * Handle the auth "created" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function created($model)
    {
        // Do something
        /* Create accounts */
        $datetime = $model->asLocalTime($model->created_at);
        $accountId = $model->trade_account_id;
        $accountables = $model->heldCurrencyModels();
        foreach ($accountables as $account) {
            $account::create([
                'id' => $accountId,
                'amount' => 0,
                'created_at' => $datetime,
                'updated_at' => $datetime
            ]);
        }
    }

    /**
     * Handle the auth "updated" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function updated($model)
    {
        // Do something
        /* Only forget cache can be used */
        /* If you use cache put model entity, the data will be abnormal */
        Cache::forget(TokenAuth::getCacheKey($model->id, TokenAuth::getAuthGuard(Auth::class)));
    }

    /**
     * Handle the auth "deleted" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function deleted($model)
    {
        // Do something
        /* Forget cache */
        Cache::forget(TokenAuth::getCacheKey($model->id, TokenAuth::getAuthGuard(Auth::class)));
    }

    /**
     * Handle the auth "force deleted" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function forceDeleted($model)
    {
        // Do something
        /* Forget cache */
        Cache::forget(TokenAuth::getCacheKey($model->id, TokenAuth::getAuthGuard(Auth::class)));
    }
}
