<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = 'admin@system.com';
        $password = 'admin2020';
        if (! App\Entities\Admin\User::where('account', $account)->first()) {
            /* Default admin */
            App\Entities\Admin\User::create([
                'account' =>  $account,
                'password' => $password,
                'email' => "admin@system.com",
                'name' => "Admin",
                'authority' => ['*']
            ]);
        }
        // Factory make test
        // Model::unguard();
        // factory(App\Entities\Admin\User::class, 3)->create();
        // Model::reguard();
    }
}
