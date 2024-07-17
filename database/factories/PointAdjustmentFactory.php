<?php

use App\Enums\PointAdjustmentsEnum;
use Faker\Generator as Faker;

$factory->define(App\Models\PointAdjustment::class, function (Faker $faker) {
    $type = PointAdjustmentsEnum::getValues();

    return [
        'points' => rand(1, 5),
        'note' => $faker->realText(rand(10, 300)),
        'competition_type' => $type[rand(0, 1)],
    ];
});
