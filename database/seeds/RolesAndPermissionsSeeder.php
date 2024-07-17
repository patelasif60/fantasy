<?php

use App\Enums\Role\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Role::create(['name' => RoleEnum::SUPERADMIN]);
        Role::create(['name' => RoleEnum::STAFF]);
        Role::create(['name' => RoleEnum::USER]);
    }
}
