<?php

use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPoint;
use Illuminate\Database\Seeder;

class TeamPlayerPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = Team::first();
        $teamPoint = TeamPoint::where('team_id', $team->id)->first();
        $player = TeamPlayerContract::active()->first();

        factory(TeamPlayerPoint::class, 1)->create([
            'team_id'       =>  $team->id,
            'player_id'     =>  $player->player_id,
            'team_point_id' =>  $teamPoint->id,
            'goals'         =>  '1',
            'assists'       =>  '1',
            'clean_sheets'  =>  '1',
            'conceded'      =>  '1',
            'app'           =>  '0',
            'total'         =>  '4',
        ]);
    }
}
