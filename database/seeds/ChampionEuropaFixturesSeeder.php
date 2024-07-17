<?php

use App\Models\GameWeek;
use App\Models\Season;
use Illuminate\Database\Seeder;

class ChampionEuropaFixturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // call once
        //Artisan::call('championeuropa:generate-fixtures');
        // IMP change season id to previous
        $gameweeks = GameWeek::where('season_id', 30)->where('end', '<=', now()->format('Y-m-d'))->orderBy('end', 'ASC')->get();

        //echo "<pre>";print_r($gameweeks);echo "</pre>";exit;
        foreach ($gameweeks as $gameweek) {
            Artisan::call('championeuropa:update', [
                'date' => $gameweek->end->addDays(1)->toDateString(),
            ]);
        }
    }
}
