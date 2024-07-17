<?php

use App\Models\Player;
use Illuminate\Database\Seeder;

class NewSeasonPlayersForCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/aecor_player_list_updated_2020.csv', 'r')) !== false) {
            $flag = true;

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                [
                    $firstName, $lastName, $club, $position, $status, $shirtName, $uid,
                    $correctFirstName, $correctLastName, $correctShirtName, $correctPosition, $correctClub, $correctStatus, $shortcode
                ] = $data;

                $p = Player::where('first_name', $firstName)->where('last_name', $lastName)->first();

                // If player not found, try searching with correct first name and last name.
                if (! $p) {
                    $searchByFirstName = ($correctFirstName && $correctFirstName != '' && $correctFirstName != 'NULL') ? $correctFirstName : $firstName;
                    $searchByLastName = ($correctLastName && $correctLastName != '' && $correctLastName != 'NULL') ? $correctLastName : $lastName;

                    $p = Player::where('first_name', $searchByFirstName)->where('last_name', $searchByLastName)->first();

                    if (! $p) {
                        continue;
                    }
                }

                $p->update([
                    'short_code' => ($shortcode !== 'NULL' && $shortcode !== '') ? $shortcode : null,
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
                    'is_active' => $this->isStatusActive($correctStatus, $shortcode),
                ];

                if ($correctPosition) {
                    $contract['position'] = $correctPosition;
                }
                $p->playerContract->update($contract);
            }
        }
    }

    public function isStatusActive($correctStatus, $shortcode)
    {
        if (strtolower($correctStatus) === 'active' && $shortcode) {
            return true;
        }

        return false;
    }
}
