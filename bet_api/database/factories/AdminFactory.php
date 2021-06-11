<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Admin\User::class, function (Faker $faker) {
    $account = $faker->email;
    $password = '123456789';
    return [
        'account' =>  $account,
        'password' => $password,
        'email' => $account,
        'name' => $faker->userName,
        'authority' => ['*']
    ];
});
