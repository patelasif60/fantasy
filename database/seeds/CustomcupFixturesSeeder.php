<?php

use App\Models\GameWeek;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomcupFixturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gameweeks = GameWeek::where('season_id', Season::getLatestSeason())->where('end', '<=', now()->format('Y-m-d'))->orderBy('end', 'ASC')->get();

        foreach ($gameweeks as $gameweek) {
            Artisan::call('customcupfixtures:generate', [
                'date' => $gameweek->start->toDateString(),
            ]);

            Artisan::call('customcupfixtures:update', [
                'date' => Carbon::parse($gameweek->end)->addDay()->toDateString(),
            ]);

            Artisan::call('customcupfixtures:generate-next', [
                'date' => Carbon::parse($gameweek->end)->addDay()->toDateString(),
            ]);
        }
    }
}
