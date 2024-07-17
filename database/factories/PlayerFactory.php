<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Player::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'short_code' => 'CODE'.strtoupper($faker->word).rand(1000, 9999),
        'api_id' => 'APIID'.strtoupper($faker->word).rand(1000, 9999),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
