<?php

use App\Models\PredefinedCrest;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Team::class, function (Faker $faker) {
    $crests = PredefinedCrest::pluck('id');

    return [
        'name' => $faker->firstName.' '.$faker->randomElement([
            'XI', 'Rockers', 'FC', 'Team', 'Wolves', 'Elephants', 'Royals', 'Turtles', 'Zonkers', 'Paper Porcupines', 'Clowns',
            'Rag Gentlemen', 'Fire Thunderballs', 'Novelty Blast', 'Scoreless Hyenas', 'Hurricanes', 'Knights', 'Scintillating Assassins',
            'Adamant Gangsters', 'Enchanting Gang', 'Bizarre Butchers', 'Sharpshooters', 'Devils', 'Slayers',
        ]),
        'crest_id' => $faker->randomElement($crests),
        'uuid' => (string) Str::uuid(),
    ];
});
