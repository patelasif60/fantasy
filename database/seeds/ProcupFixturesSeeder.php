<?php

use App\Models\GameWeek;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProcupFixturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gameweeks = GameWeek::where('season_id', Season::getLatestSeason())->where('end', '<=', now()->format('Y-m-d'))->orderBy('end', 'ASC')->get();

        $initialDate = Carbon::parse($gameweeks->first()->start)->subDay()->toDateString();

        // call once
        Artisan::call('procupfixtures:generate-initial', [
            $initialDate,
        ]);

        foreach ($gameweeks as $gameweek) {
            Artisan::call('procupfixtures:update', [
                'date' => $gameweek->end->addDays(1)->toDateString(),
            ]);

            Artisan::call('procupfixtures:generate-next', [
                'date' => $gameweek->end->addDays(1)->toDateString(),
            ]);
        }
    }
}
