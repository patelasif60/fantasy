<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Season::class, function (Faker $faker) {
    return [
        'premier_api_id' => rand(10, 99),
        'facup_api_id' => rand(10, 99),
    ];
});
