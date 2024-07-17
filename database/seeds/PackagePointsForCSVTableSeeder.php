<?php

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackagePointsForCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/package_points.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $package_id = string_preg_replace($data[0]);
                $pacakge = Package::where('name', $package_id)->first();

                if ($pacakge) {
                    $events = string_preg_replace($data[1]);
                    $goal_keeper = string_preg_replace($data[2]);
                    $centre_back = string_preg_replace($data[3]);
                    $full_back = string_preg_replace($data[4]);
                    $defensive_mid_fielder = string_preg_replace($data[5]);
                    $mid_fielder = string_preg_replace($data[6]);
                    $striker = string_preg_replace($data[7]);

                    $pacakge->packagePoints()->create([
                        'events' => $events,
                        'goal_keeper' => $goal_keeper,
                        'centre_back' => $centre_back,
                        'full_back' => $full_back,
                        'defensive_mid_fielder' => $defensive_mid_fielder,
                        'mid_fielder' => $mid_fielder,
                        'striker' => $striker,
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
