<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Club::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'api_id' => 'APIID'.strtoupper($faker->word).rand(1000, 9999),
        'short_name' => $faker->word,
        'short_code' => 'CODE'.strtoupper($faker->word).rand(1000, 9999),
        'is_premier' => rand(0, 1),
    ];
});
