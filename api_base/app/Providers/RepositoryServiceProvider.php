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
        //:end-bindings:
    }
}
