<?php

use App\Models\Division;
use App\Models\DivisionTeam;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DivisionTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $seasons = Season::pluck('id');
        // $divisions = Division::pluck('id');
        // $managers = Consumer::pluck('id');

        $division = Division::pluck('id');
        $team = Team::pluck('id');
        $season = Season::orderBy('id', 'desc')->first();
        $sizeOfTeam = count($team);
        $sizeOfDivision = count($division);

        if ($sizeOfTeam > 0) {
            for ($index = 0; $index < 6; $index++) {
                $season_id = $season->id;
                $division_id = $index + 1;
                $team_id = $index + 1;
                factory(DivisionTeam::class)->create(['season_id' => $season_id, 'division_id' => $division_id, 'team_id' => $team_id]);
            }
        } else {
            factory(Team::class, 20)->create();
        }
    }
}
