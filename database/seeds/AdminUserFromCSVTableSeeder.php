<?php

use App\Enums\Role\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserFromCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/admin_users.csv', 'r')) !== false) {
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

                $user = User::create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'username' => $username,
                    'email_verified_at' => now(),
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(10),
                    'provider' => 'email',
                    'status' => UserStatusEnum::ACTIVE,
                ]);

                $user->assignRole(RoleEnum::SUPERADMIN);
            }
            fclose($handle);
        }
    }
}
