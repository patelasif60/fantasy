<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App developers (consumers)

        factory(\App\Models\User::class)->states('with_completed_consumer_profile')->create([
            'email' => config('fantasy.default_admin_email'),
            'first_name' => 'default',
            'last_name' => 'admin',
        ]);
        // factory(User::class)->states('with_completed_consumer_profile')->create([
        //     'email' => 'rpatel@aecordigital.com',
        //     'first_name' => 'Ruchit',
        //     'last_name' => 'Patel',
        // ]);
        // factory(\App\Models\User::class)->states('with_completed_consumer_profile')->create([
        //     'email' => 'npatel@aecordigital.com',
        //     'first_name' => 'Nirav',
        //     'last_name' => 'Patel',
        // ]);

        // factory(User::class, 30)->states('with_completed_consumer_profile')->create();
        // factory(User::class, 10)->states('with_incomplete_consumer_profile')->create();
    }
}
