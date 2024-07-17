<?php

use App\Enums\Role\RoleEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersFromCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/users.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $first_name = string_preg_replace($data[0]);
                $last_name = string_preg_replace($data[1]);
                $email = string_preg_replace($data[2]);
                $username = string_preg_replace($data[3]) ? string_preg_replace($data[3]) : string_preg_replace($data[2]);
                $password = string_preg_replace($data[4]);
                $status = string_preg_replace($data[5]);
                $dob = Carbon::createFromFormat('Y-m-d H:i:s', string_preg_replace($data[6]));
                $address_1 = string_preg_replace($data[7]);
                $address_2 = string_preg_replace($data[8]);
                $town = string_preg_replace($data[9]);
                $county = string_preg_replace($data[10]);
                $post_code = string_preg_replace($data[11]);
                $country = string_preg_replace($data[12]);
                $telephone = string_preg_replace($data[13]);
                $country_code = string_preg_replace($data[14]);
                $favourite_club = string_preg_replace($data[15]);
                $introduction = string_preg_replace($data[16]);
                $has_games_news = string_preg_replace($data[17]) ? string_preg_replace($data[17]) : false;
                //$has_fl_marketing = string_preg_replace($data[18]) ? string_preg_replace($data[18]) : false;
                $has_third_parities = string_preg_replace($data[18]) ? string_preg_replace($data[18]) : false;

                $user = User::create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'username' => $username,
                    'email_verified_at' => now(),
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(10),
                    'provider' => 'email',
                    'status' => ucfirst($status),
                ]);

                $user->assignRole(RoleEnum::USER);

                $consumer = $user->consumer()->create([
                    'dob' => $dob,
                    'address_1' => $address_1,
                    'address_2' => $address_2,
                    'town' => $town,
                    'county' => $county,
                    'post_code' => $post_code,
                    'country' => $country,
                    'country_code' => $country_code,
                    'telephone' => $telephone,
                    'favourite_club' => $favourite_club,
                    'introduction' => $introduction,
                    'has_games_news' => $has_games_news,
                    //          'has_fl_marketing' => $has_fl_marketing,
                    'has_third_parities' => $has_third_parities,
                ]);
            }
            fclose($handle);
        }
    }
}
