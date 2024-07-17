<?php

use App\Models\DivisionTeam;
use App\Models\HeadToHeadFixture;
use App\Models\Season;
use Illuminate\Database\Seeder;

class HeadToHeadFixtureClearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DivisionTeam::where('season_id', Season::getLatestSeason())->update(['number' => null]);
        HeadToHeadFixture::where('season_id', Season::getLatestSeason())->delete();
    }
}
