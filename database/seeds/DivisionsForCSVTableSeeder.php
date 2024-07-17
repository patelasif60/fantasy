<?php

use App\Models\Division;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DivisionsForCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/divisions.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $package_id = string_preg_replace($data[2]);
                $pacakge = Package::where('name', $package_id)->first();

                $chairman_id = string_preg_replace($data[1]);
                $user = User::where('email', $chairman_id)->first();

                if ($pacakge) {
                    $name = string_preg_replace($data[0]);
                    $introduction = string_preg_replace($data[3]);
                    $parent_division_id = string_preg_replace($data[4]) ? string_preg_replace($data[4]) : null;
                    $auction_types = string_preg_replace($data[5]);
                    $auction_date = Carbon::createFromFormat('Y-m-d H:i:s', string_preg_replace($data[6]));
                    $pre_season_auction_budget = string_preg_replace($data[7]) ? string_preg_replace($data[7]) : null;
                    $pre_season_auction_bid_increment = string_preg_replace($data[8]) ? string_preg_replace($data[8]) : null;
                    $budget_rollover = string_preg_replace($data[9]) ? string_preg_replace($data[9]) : null;
                    $seal_bids_budget = string_preg_replace($data[10]) ? string_preg_replace($data[10]) : null;
                    $seal_bid_increment = string_preg_replace($data[11]) ? string_preg_replace($data[11]) : null;
                    $seal_bid_minimum = string_preg_replace($data[12]) ? string_preg_replace($data[12]) : null;
                    $manual_bid = string_preg_replace($data[13]) ? string_preg_replace($data[13]) : null;
                    $first_seal_bid_deadline = string_preg_replace($data[14]) ? string_preg_replace($data[14]) : null;
                    $seal_bid_deadline_repeat = string_preg_replace($data[15]) ? string_preg_replace($data[15]) : null;
                    $max_seal_bids_per_team_per_round = string_preg_replace($data[16]) ? string_preg_replace($data[16]) : null;
                    $money_back = string_preg_replace($data[17]) ? string_preg_replace($data[17]) : null;
                    $tie_preference = string_preg_replace($data[18]) ? string_preg_replace($data[18]) : null;
                    $rules = string_preg_replace($data[19]);
                    $default_squad_size = string_preg_replace($data[20]) ? string_preg_replace($data[20]) : null;
                    $default_max_player_each_club = string_preg_replace($data[21]) ? string_preg_replace($data[21]) : null;
                    $available_formations = string_preg_replace($data[22]) ? string_preg_replace($data[22]) : null;

                    $available_formations_data = [];
                    collect(explode(',', $available_formations))->each(function ($value, $key) use (&$available_formations_data) {
                        array_push($available_formations_data, str_replace('-', '', $value));
                    });

                    $defensive_midfields = string_preg_replace($data[23]) == 'TRUE' ? 'Yes' : 'No';
                    $merge_defenders = string_preg_replace($data[24]) == 'TRUE' ? 'Yes' : 'No';
                    $allow_weekend_changes = string_preg_replace($data[25]) ? string_preg_replace($data[25]) : null;
                    $enable_free_agent_transfer = string_preg_replace($data[26]) ? string_preg_replace($data[26]) : null;
                    $free_agent_transfer_authority = string_preg_replace($data[27]) ? string_preg_replace($data[27]) : null;
                    $free_agent_transfer_after = string_preg_replace($data[28]) ? string_preg_replace($data[28]) : null;
                    $season_free_agent_transfer_limit = string_preg_replace($data[29]) ? string_preg_replace($data[29]) : null;
                    $monthly_free_agent_transfer_limit = string_preg_replace($data[30]) ? string_preg_replace($data[30]) : null;

                    Division::create([
                        'name' => $name,
                        'uuid' => (string) Str::uuid(),
                        'chairman_id' => $user ? $user->consumer->id : 0,
                        'package_id' => $pacakge->id,
                        'introduction' => $introduction,
                        'parent_division_id' => $parent_division_id,
                        'auction_types' => $auction_types,
                        'auction_date' => $auction_date,
                        'pre_season_auction_budget' => $pre_season_auction_budget,
                        'pre_season_auction_bid_increment' => $pre_season_auction_bid_increment,
                        'budget_rollover' => $budget_rollover,
                        'seal_bids_budget' => $seal_bids_budget,
                        'seal_bid_increment' => $seal_bid_increment,
                        'seal_bid_minimum' => $seal_bid_minimum,
                        'manual_bid' => $manual_bid,
                        'first_seal_bid_deadline' => $first_seal_bid_deadline,
                        'seal_bid_deadline_repeat' => $seal_bid_deadline_repeat,
                        'max_seal_bids_per_team_per_round' => $max_seal_bids_per_team_per_round,
                        'money_back' => $money_back,
                        'tie_preference' => $tie_preference,
                        'rules' => $rules,
                        'default_squad_size' => $default_squad_size,
                        'default_max_player_each_club' => $default_max_player_each_club,
                        'available_formations' => $available_formations_data,
                        'defensive_midfields' => $defensive_midfields,
                        'merge_defenders' => $merge_defenders,
                        'allow_weekend_changes' => $allow_weekend_changes,
                        'enable_free_agent_transfer' => $enable_free_agent_transfer,
                        'free_agent_transfer_authority' => $free_agent_transfer_authority,
                        'free_agent_transfer_after' => $free_agent_transfer_after,
                        'season_free_agent_transfer_limit' => $season_free_agent_transfer_limit,
                        'monthly_free_agent_transfer_limit' => $monthly_free_agent_transfer_limit,
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
