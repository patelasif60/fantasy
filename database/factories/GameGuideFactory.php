<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\GameGuide;
use Faker\Generator as Faker;

$factory->define(GameGuide::class, function (Faker $faker) {
    return [
        'name' =>  $faker->firstName,
        'chairman_id' => 1,
        'package_id' => $package->id,
        'introduction' => $faker->realText(150),
        'parent_division_id' => null,
        'uuid' => (string) Str::uuid(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
