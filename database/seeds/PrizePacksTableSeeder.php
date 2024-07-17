<?php

use App\Models\PrizePack;
use Illuminate\Database\Seeder;

class PrizePacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/prize_packs.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $name = string_preg_replace($data[0]);
                $price = string_preg_replace($data[1]);
                $short_description = string_preg_replace($data[2]);
                $long_description = string_preg_replace($data[3]);
                $is_enabled = string_preg_replace($data[4]);
                $is_default = string_preg_replace($data[5]) == 'TRUE' ? 1 : 0;
                $badge_color = string_preg_replace($data[6]);

                $prizePacks = PrizePack::create([
                    'name' => $name,
                    'price' => $price,
                    'short_description' => $short_description,
                    'long_description' => $long_description,
                    'is_enabled' => $is_enabled,
                    'is_default' => $is_default,
                    'badge_color' => $badge_color,
                ]);
            }
            fclose($handle);
        }
    }
}
