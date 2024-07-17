<?php

use App\Enums\Role\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email'=>'bgrout@aecordigital.com',
            'username'=>'bengrout',
            'password'=>'$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ]);

        $user->assignRole(RoleEnum::USER);
    }
}
