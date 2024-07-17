<?php

namespace App\Repositories;

use App\Models\Package;
use App\Models\Season;
use App\Models\PackagePoint;
use Illuminate\Support\Arr;

class PackageRepository
{
    public function getPackages()
    {
        return Package::orderBy('name')->pluck('name', 'id');
    }

    public function getPackagesBySeason($season)
    {
        $season = Season::find($season);

        return Package::whereIn('id', $season->available_packages)
                        ->orderBy('name')
                        ->pluck('name', 'id');
    }

    public function create($data)
    {
        $package = Package::create([
            'is_enabled' => Arr::get($data, 'is_enabled'),
            'name' => $data['name'],
            'display_name' => Arr::get($data, 'display_name'),
            'short_description' => Arr::get($data, 'short_description'),
            'long_description' => Arr::get($data, 'long_description'),
            'prize_packs' => Arr::get($data, 'prize_packs'),
            'default_prize_pack' => Arr::get($data, 'default_prize_pack'),
            'available_new_user' => Arr::get($data, 'available_new_user'),
            'price' => ! is_null(Arr::get($data, 'price')) ? $data['price'] : 0,
            'private_league' => Arr::get($data, 'private_league'),
            'minimum_teams' => $data['minimum_teams'],
            'maximum_teams' => $data['maximum_teams'],
            'max_free_places' => $data['max_free_places'],
            'free_placce_for_new_user' => Arr::get($data, 'free_placce_for_new_user'),
            'enable_supersubs' => Arr::get($data, 'enable_supersubs'),
            'auction_types' => Arr::get($data, 'auction_types'),
            'pre_season_auction_budget' => $data['pre_season_auction_budget'],
            'pre_season_auction_bid_increment' => $data['pre_season_auction_bid_increment'],
            'budget_rollover' => Arr::get($data, 'budget_rollover'),
            'seal_bids_budget' => $data['seal_bids_budget'],
            'seal_bid_increment' => $data['seal_bid_increment'],
            'seal_bid_minimum' => $data['seal_bid_minimum'],
            'manual_bid' => Arr::get($data, 'manual_bid'),
            'first_seal_bid_deadline' => ! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? $data['first_seal_bid_deadline'] : null,
            'seal_bid_deadline_repeat' => Arr::get($data, 'seal_bid_deadline_repeat'),
            'max_seal_bids_per_team_per_round' => $data['max_seal_bids_per_team_per_round'],
            'money_back' => Arr::has($data, 'money_back_types') ? $data['money_back_types'][0] : '',
            'tie_preference' => Arr::get($data, 'tie_preference'),
            'allow_season_budget' => Arr::get($data, 'allow_season_budget'),
            'custom_squad_size' => Arr::get($data, 'custom_squad_size'),
            'default_squad_size' => $data['default_squad_size'],
            'custom_club_quota' => Arr::get($data, 'custom_club_quota'),
            'default_max_player_each_club' => $data['default_max_player_each_club'],
            'available_formations' => Arr::has($data, 'available_formations') ? $data['available_formations'] : '',
            'defensive_midfields' => Arr::get($data, 'defensive_midfields'),
            'merge_defenders' => Arr::get($data, 'merge_defenders'),
            'enable_free_agent_transfer' => Arr::get($data, 'enable_free_agent_transfer'),
            'free_agent_transfer_authority' => Arr::get($data, 'free_agent_transfer_authority'),
            'free_agent_transfer_after' => Arr::get($data, 'free_agent_transfer_after'),
            'season_free_agent_transfer_limit' => $data['season_free_agent_transfer_limit'],
            'monthly_free_agent_transfer_limit' => $data['monthly_free_agent_transfer_limit'],
            'allow_weekend_changes' => Arr::get($data, 'allow_weekend_changes'),
            'allow_custom_cup' => Arr::get($data, 'allow_custom_cup'),
            'allow_fa_cup' => Arr::get($data, 'allow_fa_cup'),
            'allow_champion_league' => Arr::get($data, 'allow_champion_league'),
            'allow_europa_league' => Arr::get($data, 'allow_europa_league'),
            'allow_head_to_head' => Arr::get($data, 'allow_head_to_head'),
            'allow_linked_league' => Arr::get($data, 'allow_linked_league'),
            'allow_process_bids' => Arr::get($data, 'allow_process_bids'),
            'allow_auction_budget' => Arr::get($data, 'allow_auction_budget'),
            'allow_bid_increment' => Arr::get($data, 'allow_bid_increment'),
            'digital_prize_type' => Arr::get($data, 'digital_prize_type'),
            'allow_custom_scoring' => Arr::get($data, 'allow_custom_scoring'),
            'badge_color' => Arr::get($data, 'badge_color'),
            'allow_defensive_midfielders' => Arr::get($data, 'allow_defensive_midfielders'),
            'allow_merge_defenders' => Arr::get($data, 'allow_merge_defenders'),
            'allow_weekend_changes_editable' => Arr::get($data, 'allow_weekend_changes_editable'),
            'allow_rollover_budget' => Arr::get($data, 'allow_rollover_budget'),
            'allow_available_formations' => Arr::get($data, 'allow_available_formations'),
            'allow_supersubs' => Arr::get($data, 'allow_supersubs'),
            'allow_seal_bid_deadline_repeat' => Arr::get($data, 'allow_seal_bid_deadline_repeat'),
            'allow_season_free_agent_transfer_limit' => Arr::get($data, 'allow_season_free_agent_transfer_limit'),
            'allow_monthly_free_agent_transfer_limit' => Arr::get($data, 'allow_monthly_free_agent_transfer_limit'),
            'allow_free_agent_transfer_authority' => Arr::get($data, 'allow_free_agent_transfer_authority'),
            'allow_enable_free_agent_transfer' => Arr::get($data, 'allow_enable_free_agent_transfer'),
            'allow_enable_free_agent_transfer' => Arr::get($data, 'allow_enable_free_agent_transfer'),
            'allow_free_agent_transfer_after' => Arr::get($data, 'allow_free_agent_transfer_after'),
            'allow_seal_bid_minimum' => Arr::get($data, 'allow_seal_bid_minimum'),
            'allow_money_back' => Arr::get($data, 'allow_money_back'),
            'money_back_types' => Arr::has($data, 'money_back_types') ? $data['money_back_types'] : '',
            'allow_tie_preference' => Arr::get($data, 'allow_tie_preference'),
            'allow_max_bids_per_round' => Arr::get($data, 'allow_max_bids_per_round'),
        ]);

        $pakagePoint = [];
        foreach ($data['points'] as $eventKey => $positionValues) {
            $tempData = [];
            foreach ($positionValues as $positionKey => $positionValue) {
                $tempData['events'] = $eventKey;
                $tempData[$positionKey] = $positionValue;
            }
            array_push($pakagePoint, $tempData);
        }
        $package->packagePoints()->createMany($pakagePoint);

        return $package;
    }

    public function update($package, $data)
    {
        $package->fill([
            'is_enabled' => Arr::get($data, 'is_enabled'),
            'name' => $data['name'],
            'display_name' => Arr::get($data, 'display_name'),
            'short_description' => Arr::get($data, 'short_description'),
            'long_description' => Arr::get($data, 'long_description'),
            'prize_packs' => Arr::get($data, 'prize_packs'),
            'default_prize_pack' => Arr::get($data, 'default_prize_pack'),
            'available_new_user' => Arr::get($data, 'available_new_user'),
            'price' => ! is_null(Arr::get($data, 'price')) ? $data['price'] : 0,
            'private_league' => Arr::get($data, 'private_league'),
            'minimum_teams' => $data['minimum_teams'],
            'maximum_teams' => $data['maximum_teams'],
            'max_free_places' => $data['max_free_places'],
            'free_placce_for_new_user' => Arr::get($data, 'free_placce_for_new_user'),
            'enable_supersubs' => Arr::get($data, 'enable_supersubs'),
            'auction_types' => Arr::get($data, 'auction_types'),
            'pre_season_auction_budget' => $data['pre_season_auction_budget'],
            'pre_season_auction_bid_increment' => $data['pre_season_auction_bid_increment'],
            'budget_rollover' => Arr::get($data, 'budget_rollover'),
            'seal_bids_budget' => $data['seal_bids_budget'],
            'seal_bid_increment' => $data['seal_bid_increment'],
            'seal_bid_minimum' => $data['seal_bid_minimum'],
            'manual_bid' => Arr::get($data, 'manual_bid'),
            'first_seal_bid_deadline' => ! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? $data['first_seal_bid_deadline'] : null,
            'seal_bid_deadline_repeat' => Arr::get($data, 'seal_bid_deadline_repeat'),
            'max_seal_bids_per_team_per_round' => $data['max_seal_bids_per_team_per_round'],
            'money_back' => Arr::has($data, 'money_back_types') ? $data['money_back_types'][0] : '',
            'tie_preference' => Arr::get($data, 'tie_preference'),
            'allow_season_budget' => Arr::get($data, 'allow_season_budget'),
            'custom_squad_size' => Arr::get($data, 'custom_squad_size'),
            'default_squad_size' => $data['default_squad_size'],
            'custom_club_quota' => Arr::get($data, 'custom_club_quota'),
            'default_max_player_each_club' => $data['default_max_player_each_club'],
            'available_formations' => Arr::has($data, 'available_formations') ? $data['available_formations'] : '',
            'defensive_midfields' => Arr::get($data, 'defensive_midfields'),
            'merge_defenders' => Arr::get($data, 'merge_defenders'),
            'enable_free_agent_transfer' => Arr::get($data, 'enable_free_agent_transfer'),
            'free_agent_transfer_authority' => Arr::get($data, 'free_agent_transfer_authority'),
            'free_agent_transfer_after' => Arr::get($data, 'free_agent_transfer_after'),
            'season_free_agent_transfer_limit' => $data['season_free_agent_transfer_limit'],
            'monthly_free_agent_transfer_limit' => $data['monthly_free_agent_transfer_limit'],
            'allow_weekend_changes' => Arr::get($data, 'allow_weekend_changes'),
            'allow_custom_cup' => Arr::get($data, 'allow_custom_cup'),
            'allow_fa_cup' => Arr::get($data, 'allow_fa_cup'),
            'allow_champion_league' => Arr::get($data, 'allow_champion_league'),
            'allow_europa_league' => Arr::get($data, 'allow_europa_league'),
            'allow_head_to_head' => Arr::get($data, 'allow_head_to_head'),
            'allow_linked_league' => Arr::get($data, 'allow_linked_league'),
            'allow_process_bids' => Arr::get($data, 'allow_process_bids'),
            'allow_auction_budget' => Arr::get($data, 'allow_auction_budget'),
            'allow_bid_increment' => Arr::get($data, 'allow_bid_increment'),
            'digital_prize_type' => Arr::get($data, 'digital_prize_type'),
            'allow_custom_scoring' => Arr::get($data, 'allow_custom_scoring'),
            'badge_color' => Arr::get($data, 'badge_color'),
            'allow_defensive_midfielders' => Arr::get($data, 'allow_defensive_midfielders'),
            'allow_merge_defenders' => Arr::get($data, 'allow_merge_defenders'),
            'allow_weekend_changes_editable' => Arr::get($data, 'allow_weekend_changes_editable'),
            'allow_rollover_budget' => Arr::get($data, 'allow_rollover_budget'),
            'allow_available_formations' => Arr::get($data, 'allow_available_formations'),
            'allow_supersubs' => Arr::get($data, 'allow_supersubs'),
            'allow_seal_bid_deadline_repeat' => Arr::get($data, 'allow_seal_bid_deadline_repeat'),
            'allow_season_free_agent_transfer_limit' => Arr::get($data, 'allow_season_free_agent_transfer_limit'),
            'allow_monthly_free_agent_transfer_limit' => Arr::get($data, 'allow_monthly_free_agent_transfer_limit'),
            'allow_free_agent_transfer_authority' => Arr::get($data, 'allow_free_agent_transfer_authority'),

            'allow_enable_free_agent_transfer' => Arr::get($data, 'allow_enable_free_agent_transfer'),
            'allow_enable_free_agent_transfer' => Arr::get($data, 'allow_enable_free_agent_transfer'),
            'allow_free_agent_transfer_after' => Arr::get($data, 'allow_free_agent_transfer_after'),
            'allow_seal_bid_minimum' => Arr::get($data, 'allow_seal_bid_minimum'),
            'allow_money_back' => Arr::get($data, 'allow_money_back'),
            'money_back_types' => Arr::has($data, 'money_back_types') ? $data['money_back_types'] : '',
            'allow_tie_preference' => Arr::get($data, 'allow_tie_preference'),
            'allow_max_bids_per_round' => Arr::get($data, 'allow_max_bids_per_round'),
        ])->save();

        foreach ($data['points'] as $eventKey => $positionValues) {
            $points = [];
            foreach ($positionValues as $positionKey => $positionValue) {
                $points[$positionKey] = $positionValue;
            }

            PackagePoint::updateOrCreate(
                ['package_id' => $package->id, 'events' => $eventKey], $points
            );
        }

        return $package;
    }

    public function list()
    {
        return Package::select(['id', 'name', 'short_description'])->get();
    }

    public function getLeagueType()
    {
        return Package::orderBy('name')->pluck('private_league', 'name');
    }
}
