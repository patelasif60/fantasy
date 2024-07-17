<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Auction::class, function (Faker $faker) {
    return [
        'short_description' => $faker->realText(200),
        'long_description' => $faker->realText(300),
    ];
});
