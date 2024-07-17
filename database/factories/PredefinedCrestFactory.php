<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PredefinedCrest::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'is_published' => 1,
    ];
});
