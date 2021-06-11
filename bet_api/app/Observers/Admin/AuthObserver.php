<?php

namespace App\Observers\Admin;

use App\Entities\Admin\Auth as Auth;
use Cache;
use TokenAuth;

/**
 * Class AuthObserver.
 *
 * @package App\Observers\Admin
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
