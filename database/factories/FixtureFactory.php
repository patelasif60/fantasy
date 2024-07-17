<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Fixture::class, function (Faker $faker) {
    return [
        'season_id' => factory(App\Models\Season::class)->create(),
        'competition' => '',
        'home_club_id'=> factory(App\Models\Club::class)->create(),
        'away_club_id'=> factory(App\Models\Club::class)->create(),
        'api_id' => 'APIID'.strtoupper($faker->word).rand(1000, 9999),
        'date_time' => Carbon::now()->addDays(1),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
