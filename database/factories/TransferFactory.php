<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Transfer::class, function (Faker $faker) {
    //values
    $transfer_type = ['sealedbids', 'transfer', 'trade', 'auction', 'substitution', 'budgetcorrection', 'supersub', 'swapdeal'];

    return [
        'transfer_type' => $transfer_type[rand(0, 5)],
        'transfer_value' => rand(10, 99),
        'transfer_date' => Carbon::now()->format(config('fantasy.time.format')),
    ];
});
