<?php

use App\Models\Fixture;
use Illuminate\Database\Seeder;

class FixturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fixtures = factory(Fixture::class, 50)->create();
    }
}
