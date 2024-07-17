<?php

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($year = 1990; $year < 2019; $year++) {
            $year_start = $year;
            $year_end = $year + 1;

            $season_name = $year_start.' - '.$year_end;

            $start_at = $year_start.'-08-'.rand(1, 31);
            $end_at = $year_end.'-04-'.rand(1, 30);

            $season = factory(Season::class)->create(['name' => $season_name, 'start_at' => $start_at, 'end_at' => $end_at, 'default_package' => 1, 'available_packages' => ['1', '2', '3', '4']]);
        }

        $latestSeason = Season::find(Season::getLatestSeason());
        $latestSeason->facup_api_id = 'ebmzpjkh2j8nvurknh30ro3fu';
        $latestSeason->premier_api_id = '6nffa62hna5tvrgg59u8wze5m';
        $latestSeason->save();
    }
}
