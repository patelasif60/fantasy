<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Package::class, function (Faker $faker) {
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

    return [
        'is_enabled' => $yes_no[rand(0, 1)],
        'name' => $faker->name,
        'display_name' => $faker->name,
        'short_description' => $faker->realText(150),
        'long_description' => $faker->realText(200),
        'available_new_user' => $yes_no[rand(0, 1)],
        'price' => rand(1, 99),
        'private_league' => $yes_no[rand(0, 1)],
        'minimum_teams' => rand(1, 16),
        'auction_types' => $auction_types[rand(0, 1)],
        'pre_season_auction_budget' => rand(0, 1000),
        'pre_season_auction_bid_increment' => rand(1, 10),
        'budget_rollover' => $yes_no[rand(0, 1)],
        'seal_bids_budget' => rand(0, 1000),
        'seal_bid_increment' => rand(0, 10),
        'seal_bid_minimum' => rand(0, 1000),
        'manual_bid' => $yes_no[rand(0, 1)],
        'first_seal_bid_deadline' => \Carbon\Carbon::now()->format(config('fantasy.db.datetime.format')),
        'seal_bid_deadline_repeat' => $seal_bid_deadline_repeat[rand(0, 3)],
        'max_seal_bids_per_team_per_round' => 1,
        'money_back' => $money_back[rand(0, 2)],
        'tie_preference' => $tie_preference[rand(0, 5)],
        'custom_squad_size' => $yes_no[rand(0, 1)],
        'default_squad_size' => rand(11, 18),
        'custom_club_quota' => $yes_no[rand(0, 1)],
        'default_max_player_each_club' => 1,
        'available_formations' => $faker->randomElements($allowed_formations, rand(1, 5)),
        'defensive_midfields' => $yes_no[rand(0, 1)],
        'merge_defenders' => $yes_no[rand(0, 1)],
        'enable_free_agent_transfer' => $yes_no[rand(0, 1)],
        'free_agent_transfer_authority' => $free_agent_transfer_authority[rand(0, 2)],
        'free_agent_transfer_after' => $free_agent_transfer_after[rand(0, 1)],
        'season_free_agent_transfer_limit' => rand(0, 1000),
        'monthly_free_agent_transfer_limit' => rand(0, 1000),
        'allow_weekend_changes' => $yes_no[rand(0, 1)],
        'allow_custom_cup' => $yes_no[rand(0, 1)],
        'allow_fa_cup' => $yes_no[rand(0, 1)],
        'allow_champion_league' => $yes_no[rand(0, 1)],
        'allow_europa_league' => $yes_no[rand(0, 1)],
        'allow_head_to_head' => $yes_no[rand(0, 1)],
        'allow_linked_league' => $yes_no[rand(0, 1)],
        'digital_prize_type' => $digital_prize_type[rand(0, 1)],
        'allow_custom_scoring' => $yes_no[rand(0, 1)],
        'badge_color' => 'gold',
    ];
});
