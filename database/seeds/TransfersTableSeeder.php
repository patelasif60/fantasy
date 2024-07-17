<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransfersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players = Player::pluck('id');
        $sizeOfPlayers = count($players);
        $teams = Team::pluck('id');
        $sizeOfPlayers = count($players);
        $sizeOfTeams = count($teams);

        if ($sizeOfPlayers > 0) {
            for ($index = 0; $index < 18; $index++) {
                $player_in = $players[rand(0, $sizeOfPlayers - 1)];
                $player_out = $players[rand(0, $sizeOfPlayers - 1)];
                $team_id = $teams[rand(0, $sizeOfTeams - 1)];
                factory(Transfer::class)->create(['team_id' => $team_id, 'player_in' => $player_in, 'player_out' => $player_out]);
            }
        } else {
            factory(Transfer::class, 20)->create();
        }
    }
}
