<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Pitch::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'is_published' => rand(0, 1),
    ];
});
