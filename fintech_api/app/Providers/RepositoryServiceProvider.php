<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Jwt\AuthRepository::class, \App\Repositories\Jwt\AuthRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Jwt\ClientRepository::class, \App\Repositories\Jwt\ClientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\System\ParameterRepository::class, \App\Repositories\System\ParameterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\System\DataActivityRepository::class, \App\Repositories\System\DataActivityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\System\AuthoritySnapshotRepository::class, \App\Repositories\System\AuthoritySnapshotRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Sms\OperateRepository::class, \App\Repositories\Sms\OperateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Message\BulletinRepository::class, \App\Repositories\Message\BulletinRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Admin\AuthRepository::class, \App\Repositories\Admin\AuthRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Admin\UserRepository::class, \App\Repositories\Admin\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Member\AuthRepository::class, \App\Repositories\Member\AuthRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Member\UserRepository::class, \App\Repositories\Member\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Trade\OperateRepository::class, \App\Repositories\Trade\OperateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Trade\CurrencyRepository::class, \App\Repositories\Trade\CurrencyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Receipt\OperateRepository::class, \App\Repositories\Receipt\OperateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Receipt\FormRepository::class, \App\Repositories\Receipt\FormRepositoryEloquent::class);
        //:end-bindings:
    }
}
