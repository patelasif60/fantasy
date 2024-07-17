<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Consumer::class, function (Faker $faker) {
    return [
        'dob' => $faker->date(),
        'address_1' => $faker->streetAddress(),
        'address_2' => $faker->streetName(),
        'town' => $faker->city(),
        'county' => $faker->country(),
        'post_code' => $faker->postcode(),
        'country' => $faker->country(),
        'country_code' => '+41',
        'telephone' => $faker->phoneNumber(),
        'favourite_club' => $faker->randomElement(['Manchester United', 'Arsenal', 'Liverpool', 'Chelsea FC']),
        'introduction' => $faker->realText(rand(10, 300)),
        'has_games_news' => $faker->boolean(),
        'has_third_parities' => $faker->boolean(),
    ];
});
