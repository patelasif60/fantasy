<?php

use Illuminate\Database\Seeder;

class HeadToHeadFixturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('allocate:numbers');
        Artisan::call('head-to-head-fixtures:generate');
        Artisan::call('head-to-head-fixtures:update', [
            '--all' => 'true',
        ]);
    }
}
