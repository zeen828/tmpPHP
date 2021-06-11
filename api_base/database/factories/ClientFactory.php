<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Jwt\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});