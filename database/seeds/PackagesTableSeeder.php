<?php

use App\Models\Package;
use App\Models\PackagePoint;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $position = ['goal', 'assist', 'goal_conceded', 'clean_sheet', 'appearance', 'club_win', 'red_card', 'yellow_card', 'own_goal', 'penalty_missed', 'penalty_save', 'goalkeeper_save_x5'];

        for ($i = 0; $i < 4; $i++) {
            $package = factory(Package::class)->create();

            foreach ($position as $key => $value) {
                PackagePoint::create([
                    'package_id' => $package->id,
                    'events' => $value,
                    'goal_keeper' => rand(0, 10),
                    'centre_back' => rand(0, 10),
                    'full_back' => rand(0, 10),
                    'defensive_mid_fielder' => rand(0, 10),
                    'mid_fielder' => rand(0, 10),
                    'striker' => rand(0, 10),
                ]);
            }
        }
    }
}
