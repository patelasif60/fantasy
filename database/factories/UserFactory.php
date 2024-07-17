<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'provider' => 'email',
        'status' => $faker->randomElement([\App\Enums\UserStatusEnum::ACTIVE, \App\Enums\UserStatusEnum::SUSPENDED]),
    ];
});

$factory->afterCreatingState(App\Models\User::class, 'with_invitation', function ($user, $faker) {
    $user->invite()->save(factory(App\Models\AdminInviteUser::class)->make());
});

$factory->afterCreatingState(App\Models\User::class, 'with_completed_consumer_profile', function ($user, $faker) {
    $user->consumer()->save(factory(App\Models\Consumer::class)->make());
    $user->assignRole(App\Enums\Role\RoleEnum::USER);
});

$factory->afterCreatingState(App\Models\User::class, 'with_incomplete_consumer_profile', function ($user, $faker) {
    $user->assignRole(App\Enums\Role\RoleEnum::USER);
});
