<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\AdminInviteUser::class, function (Faker $faker) {
    return [
        'token' => Str::random(40),
        'invited_at' => now(),
        'invite_accepted_at' => null,
    ];
});
