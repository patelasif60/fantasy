<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use Illuminate\Database\Seeder;

class TeamPlayerContractCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/team-player-contracts.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $teamNm = string_preg_replace($data[0]);
                $team = Team::where('name', $teamNm)->first();

                $player = Player::where('first_name', $data[1])->where('last_name', $data[2])->first();

                $is_active = string_preg_replace($data[3]);
                $start = string_preg_replace($data[4]);
                $end = string_preg_replace($data[5]) ? Carbon::createFromFormat('Y-m-d H:i:s', string_preg_replace($data[5])) : null;

                $contract = TeamPlayerContract::create([
                    'player_id' => $player ? $player->id : null,
                    'team_id' => $team ? $team->id : null,
                    'is_active' => $is_active == 'TRUE' ? true : false,
                    'start_date' => $start,
                    'end_date' => $end,
                ]);
            }
            fclose($handle);
        }
    }
}
