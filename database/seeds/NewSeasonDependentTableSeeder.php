<?php

use Illuminate\Database\Seeder;

class NewSeasonDependentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FootballApiTableSeeder::class);
        $this->call(GameWeeksForNewSeasonCSVTableSeeder::class);
        $this->call(FixtureStatsSeeder::class);
    }
}
