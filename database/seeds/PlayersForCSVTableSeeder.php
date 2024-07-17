<?php

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayersForCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/aecor_player_list.csv', 'r')) !== false) {
            $flag = true;

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                [
                    $firstName, $lastName, $club, $position, $status, $shirtName, $uid,
                    $correctFirstName, $correctLastName, $correctShirtName, $correctPosition, $correctStatus, $shortcode
                ] = $data;

                $p = Player::where('first_name', $firstName)->where('last_name', $lastName)->first();

                if (! $p) {
                    continue;
                }

                $p->update([
                    'short_code' => ($shortcode !== 'NULL') ? $shortcode : null,
                ]);

                if ($correctFirstName && $correctFirstName !== 'NULL') {
                    $p->update([
                        'first_name' => $correctFirstName,
                    ]);
                }

                if ($correctLastName && $correctLastName !== 'NULL') {
                    $p->update([
                        'last_name' => $correctLastName,
                    ]);
                }

                if ($correctShirtName && $correctShirtName !== 'NULL') {
                    $p->update([
                        'match_name' => $correctShirtName,
                    ]);
                }

                $contract = [
                    'is_active' => ($correctStatus === 'Inactive') ? 0 : 1,
                ];

                if ($correctPosition) {
                    $contract['position'] = $correctPosition;
                }
                $p->playerContract->update($contract);
            }
        }
    }
}
