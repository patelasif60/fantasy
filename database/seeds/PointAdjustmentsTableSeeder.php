<?php

use App\Models\PointAdjustment;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\Seeder;

class PointAdjustmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('point_adjustments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $seasons = Season::all()->random(rand(1, Season::count()));
        $teams = Team::all()->random(rand(1, Team::count()));

        foreach ($teams as $key => $team) {
            foreach ($seasons as $key => $season) {
                factory(PointAdjustment::class, rand(1, 5))->create([
                    'team_id' => $team->id,
                    'season_id' => $season->id,
                ]);
            }
        }

        $season_id = Season::getLatestSeason();
        foreach ($teams as $key => $team) {
            factory(PointAdjustment::class, rand(1, 5))->create([
                'team_id' => $team->id,
                'season_id' => $season_id,
            ]);
        }
    }
}
