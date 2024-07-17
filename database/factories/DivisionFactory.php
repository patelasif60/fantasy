<?php

use App\Models\Package;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Division::class, function (Faker $faker) {
    //values
    $yes_no = ['Yes', 'No'];
    $auction_types = ['Live', 'Online'];
    $seal_bid_deadline_repeat = ['dontRepeat', 'everyMonth', 'everyFortnight', 'everyWeek'];
    $money_back = ['none', 'hunderedPercent', 'fiftyPercent'];
    $tie_preference = ['no', 'earliestBidWins', 'lowerLeaguePositionWins', 'higherLeaguePositionWins', 'randomlyAllocated', 'randomlyAllocatedReverses'];
    $allowed_formations = [442=>442, 541=>541, 532=>532, 451=>451, 433=>433];
    $free_agent_transfer_authority = ['chairman', 'chairmanandcochairman', 'all'];
    $free_agent_transfer_after = ['auctionEnd', 'seasonStart'];
    $digital_prize_type = ['Standard', 'Basic'];

    $package = Package::inRandomOrder()->get()->first();

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
