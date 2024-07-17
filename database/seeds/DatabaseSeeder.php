<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AdminUserFromCSVTableSeeder::class);
        $this->call(UsersFromCSVTableSeeder::class);
        //$this->call(ClubsTableSeeder::class);
        $this->call(PrizePacksTableSeeder::class);
        $this->call(SeasonsTableSeeder::class);
        // $this->call(PackagesTableSeeder::class);
        $this->call(PackagesForCSVTableSeeder::class);
        $this->call(PackagePointsForCSVTableSeeder::class);
        $this->call(PredefinedCrestsTableSeeder::class);
        // $this->call(PitchesTableSeeder::class);
        // $this->call(DivisionsForCSVTableSeeder::class);
        // $this->call(DivisionsSeeder::class);
        $this->call(FixtureFormationsTableSeeder::class);
        $this->call(FixtureEventTypeTableSeeder::class);
        $this->call(FootballApiTableSeeder::class);
        $this->call(PlayersForCSVTableSeeder::class);
        $this->call(GameWeeksForPreviousSeasonCSVTableSeeder::class);
        // $this->call(HeadToHeadCalendarSeeder::class);

        //$this->call(PlayersSeeder::class);
        // $this->call(TeamsCSVTableSeeder::class);
        // $this->call(TeamsTableSeeder::class);
        // $this->call(TeamPlayerContractCSVTableSeeder::class);
        // $this->call(TeamPlayerContractSeeder::class);
        $this->call(FixtureStatsSeeder::class);
        $this->call(ProcupFixturesSeeder::class);
        $this->call(HeadToHeadFixturesSeeder::class);
        $this->call(ChampionEuropaFixturesSeeder::class);
        $this->call(CustomcupFixturesSeeder::class);
    }
}
