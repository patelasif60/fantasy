<?php

use App\Models\Fixture;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FixtureStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fixtureStart = \App\Models\Fixture::orderBy('date_time')->first()->date_time;
        $fixtureEnd = Fixture::orderBy('date_time', 'DESC')->first()->date_time;

        $start = Carbon::parse($fixtureStart);
        $end = Carbon::parse($fixtureEnd);

        while ($start->lessThan($end)) {
            Artisan::call('import:fixture-stats', [
                '--daterange' => $start->toDateString().':'.$start->addDays(1)->toDateString(),
            ]);
            $start->addDays(1);
        }
    }
}
