<?php

use App\Enums\AgentTransferAfterEnum;
use App\Enums\DigitalPrizeTypeEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferAuthorityEnum;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackagesForCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $digitalPrizeTypeEnum = DigitalPrizeTypeEnum::toSelectArray();

        if (($handle = fopen(database_path().'/seeds/files/packages.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 10000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                info($data);

                $name = string_preg_replace($data[0]);
                $display_name = string_preg_replace($data[1]);
                $short_description = string_preg_replace($data[2]);
                $long_description = string_preg_replace($data[3]);
                $prize_packs = string_preg_replace($data[4]) == 'null' ? null : string_preg_replace($data[4]);
                $prize_packs_data = [];
                collect(explode(',', $prize_packs))->each(function ($value, $key) use (&$prize_packs_data) {
                    array_push($prize_packs_data, str_replace('-', '', $value));
                });
                $available_new_user = string_preg_replace($data[5]) == 'TRUE' ? 'Yes' : 'No';
                $price = string_preg_replace($data[6]);
                $private_league = string_preg_replace($data[7]) == 'TRUE' ? 'Yes' : 'No';
                $minimum_teams = string_preg_replace($data[8]);

                $auction_types = string_preg_replace($data[9]);
                $auction_types_data = [];
                collect(explode(',', $auction_types))->each(function ($value, $key) use (&$auction_types_data) {
                    array_push($auction_types_data, str_replace('-', '', $value));
                });

                $pre_season_auction_budget = string_preg_replace($data[10]);
                $pre_season_auction_bid_increment = string_preg_replace($data[11]);
                $budget_rollover = string_preg_replace($data[12]) == 'TRUE' ? 'Yes' : 'No';
                $seal_bids_budget = string_preg_replace($data[13]);
                $seal_bid_increment = string_preg_replace($data[14]);
                $seal_bid_minimum = string_preg_replace($data[15]);
                $manual_bid = string_preg_replace($data[16]) == 'TRUE' ? 'Yes' : 'No';
                $first_seal_bid_deadline = Illuminate\Support\Carbon::createFromFormat('d-m-Y H:i', $data[17])->format('Y-m-d H:i');
                $seal_bid_deadline_repeat = array_search(string_preg_replace($data[18]), $sealedBidDeadLinesEnum);
                $seal_bid_deadline_repeat = $seal_bid_deadline_repeat ? $seal_bid_deadline_repeat : null;

                $max_seal_bids_per_team_per_round = string_preg_replace($data[19]);

                $money_back = string_preg_replace($data[20]) == 'FALSE' ? 'None' : string_preg_replace($data[20]);
                $money_back = array_search($money_back, $moneyBackEnum);
                $money_back = $money_back ? $money_back : null;

                $tie_preference = array_search(string_preg_replace($data[21]), $tiePreferenceEnum);
                $tie_preference = $tie_preference ? $tie_preference : null;

                $custom_squad_size = string_preg_replace($data[22]) == 'TRUE' ? 'Yes' : 'No';
                $default_squad_size = string_preg_replace($data[23]);
                $custom_club_quota = string_preg_replace($data[24]) == 'TRUE' ? 'Yes' : 'No';
                $default_max_player_each_club = string_preg_replace($data[25]);
                $available_formations = string_preg_replace($data[26]);

                $available_formations_data = [];
                collect(explode(',', $available_formations))->each(function ($value, $key) use (&$available_formations_data) {
                    array_push($available_formations_data, str_replace('-', '', $value));
                });

                $defensive_midfields = string_preg_replace($data[27]) == 'TRUE' ? 'Yes' : 'No';
                $merge_defenders = string_preg_replace($data[28]) == 'TRUE' ? 'Yes' : 'No';
                $enable_free_agent_transfer = string_preg_replace($data[29]) == 'TRUE' ? 'Yes' : 'No';

                $free_agent_transfer_authority = array_search(string_preg_replace($data[30]), $transferAuthority);
                $free_agent_transfer_authority = $free_agent_transfer_authority ? $free_agent_transfer_authority : null;

                $free_agent_transfer_after = array_search(string_preg_replace($data[31]), $agentTransferAfterEnum);
                $free_agent_transfer_after = $free_agent_transfer_after ? $free_agent_transfer_after : null;

                $season_free_agent_transfer_limit = string_preg_replace($data[32]);
                $monthly_free_agent_transfer_limit = string_preg_replace($data[33]);
                $allow_weekend_changes = string_preg_replace($data[35]) == 'TRUE' ? 'Yes' : 'No';
                $allow_custom_cup = string_preg_replace($data[36]) == 'TRUE' ? 'Yes' : 'No';
                $allow_fa_cup = string_preg_replace($data[37]) == 'TRUE' ? 'Yes' : 'No';
                $allow_champion_league = string_preg_replace($data[38]) == 'TRUE' ? 'Yes' : 'No';
                $allow_europa_league = string_preg_replace($data[39]) == 'TRUE' ? 'Yes' : 'No';
                $allow_head_to_head = string_preg_replace($data[40]) == 'TRUE' ? 'Yes' : 'No';
                $allow_linked_league = string_preg_replace($data[41]) == 'TRUE' ? 'Yes' : 'No';

                $digital_prize_type = array_search(string_preg_replace($data[42]), $digitalPrizeTypeEnum);
                $digital_prize_type = $digital_prize_type ? $digital_prize_type : null;

                $allow_custom_scoring = string_preg_replace($data[43]) == 'TRUE' ? 'Yes' : 'No';

                $max_free_places = string_preg_replace($data[44]);
                $allow_process_bids = string_preg_replace($data[45]) == 'TRUE' ? 'Yes' : 'No';
                $allow_auction_budget = string_preg_replace($data[46]) == 'TRUE' ? 'Yes' : 'No';
                $allow_bid_increment = string_preg_replace($data[47]) == 'TRUE' ? 'Yes' : 'No';
                $allow_defensive_midfielders = string_preg_replace($data[48]) == 'TRUE' ? 'Yes' : 'No';
                $allow_merge_defenders = string_preg_replace($data[49]) == 'TRUE' ? 'Yes' : 'No';
                $allow_weekend_changes_editable = string_preg_replace($data[50]) == 'TRUE' ? 'Yes' : 'No';
                $allow_rollover_budget = string_preg_replace($data[51]) == 'TRUE' ? 'Yes' : 'No';
                $allow_available_formations = string_preg_replace($data[52]) == 'TRUE' ? 'Yes' : 'No';
                $allow_supersubs = string_preg_replace($data[53]) == 'TRUE' ? 'Yes' : 'No';
                $allow_seal_bid_deadline_repeat = string_preg_replace($data[54]) == 'TRUE' ? 'Yes' : 'No';
                $allow_season_free_agent_transfer_limit = string_preg_replace($data[55]) == 'TRUE' ? 'Yes' : 'No';
                $allow_monthly_free_agent_transfer_limit = string_preg_replace($data[56]) == 'TRUE' ? 'Yes' : 'No';
                $allow_free_agent_transfer_authority = string_preg_replace($data[57]) == 'TRUE' ? 'Yes' : 'No';

                $badge_color = string_preg_replace($data[58]);

                $allow_enable_free_agent_transfer = string_preg_replace($data[59]) == 'TRUE' ? 'Yes' : 'No';

                $allow_free_agent_transfer_after = string_preg_replace($data[60]) == 'TRUE' ? 'Yes' : 'No';

                $allow_seal_bid_minimum = string_preg_replace($data[61]) == 'TRUE' ? 'Yes' : 'No';
                $allow_money_back = string_preg_replace($data[62]) == 'TRUE' ? 'Yes' : 'No';
                $allow_tie_preference = string_preg_replace($data[63]) == 'TRUE' ? 'Yes' : 'No';
                $money_back_types = string_preg_replace($data[64]);
                $free_placce_for_new_user = string_preg_replace($data[65]) == 'TRUE' ? 'Yes' : 'No';
                $allow_season_budget = string_preg_replace($data[66]) == 'TRUE' ? 'Yes' : 'No';

                $money_back_types_data = [];
                collect(explode(',', $money_back_types))->each(function ($value, $key) use (&$money_back_types_data) {
                    array_push($money_back_types_data, str_replace('-', '', $value));
                });
                Package::create([
                    'is_enabled' => true,
                    'name' => $name,
                    'display_name' => $display_name,
                    'short_description' => $short_description,
                    'long_description' => $long_description,
                    'prize_packs' => $prize_packs_data,
                    'available_new_user' => $available_new_user,
                    'price' => $price,
                    'private_league' => $private_league,
                    'minimum_teams' => $minimum_teams,
                    'auction_types' => $auction_types_data,
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
                    'custom_squad_size' => $custom_squad_size,
                    'default_squad_size' => $default_squad_size,
                    'custom_club_quota' => $custom_club_quota,
                    'default_max_player_each_club' => $default_max_player_each_club,
                    'available_formations' => $available_formations_data,
                    'defensive_midfields' => $defensive_midfields,
                    'merge_defenders' => $merge_defenders,
                    'enable_free_agent_transfer' => $enable_free_agent_transfer,
                    'free_agent_transfer_authority' => $free_agent_transfer_authority,
                    'free_agent_transfer_after' => $free_agent_transfer_after,
                    'season_free_agent_transfer_limit' => $season_free_agent_transfer_limit,
                    'monthly_free_agent_transfer_limit' => $monthly_free_agent_transfer_limit,
                    'allow_weekend_changes' => $allow_weekend_changes,
                    'allow_custom_cup' => $allow_custom_cup,
                    'allow_fa_cup' => $allow_fa_cup,
                    'allow_champion_league' => $allow_champion_league,
                    'allow_europa_league' => $allow_europa_league,
                    'allow_head_to_head' => $allow_head_to_head,
                    'allow_linked_league' => $allow_linked_league,
                    'digital_prize_type' => $digital_prize_type,
                    'allow_custom_scoring' => $allow_custom_scoring,
                    'max_free_places' => $max_free_places,
                    'allow_process_bids'=> $allow_process_bids,
                    'allow_auction_budget'=> $allow_auction_budget,
                    'allow_bid_increment' => $allow_bid_increment,
                    'allow_defensive_midfielders' => $allow_defensive_midfielders,
                    'allow_merge_defenders' => $allow_merge_defenders,
                    'allow_weekend_changes_editable' => $allow_weekend_changes_editable,
                    'allow_rollover_budget' => $allow_rollover_budget,
                    'allow_available_formations' => $allow_available_formations,
                    'allow_supersubs' => $allow_supersubs,
                    'allow_seal_bid_deadline_repeat' => $allow_seal_bid_deadline_repeat,
                    'allow_season_free_agent_transfer_limit' => $allow_season_free_agent_transfer_limit,
                    'allow_monthly_free_agent_transfer_limit' => $allow_monthly_free_agent_transfer_limit,
                    'allow_free_agent_transfer_authority' => $allow_free_agent_transfer_authority,
                    'badge_color' => $badge_color,
                    'money_back_types' => $money_back_types_data,
                    'free_placce_for_new_user' =>$free_placce_for_new_user,
                    'allow_season_budget' =>$allow_season_budget,
                ]);
            }
            fclose($handle);
        }
    }
}
