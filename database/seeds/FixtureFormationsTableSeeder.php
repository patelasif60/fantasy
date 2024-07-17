<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixtureFormationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        DB::table('fixture_formations')->insert([
            [
                'name'          => '4-4-2',
                'slug'          => '4-4-2',
                'created_at'    => $date,
                'updated_at'    => $date,
            ],
            [
                'name'          => '4-5-1',
                'slug'          => '4-5-1',
                'created_at'    => $date,
                'updated_at'    => $date,
            ],
            [
                'name'          => '4-3-3',
                'slug'          => '4-3-3',
                'created_at'    => $date,
                'updated_at'    => $date,
            ],
            [
                'name'          => '5-3-2',
                'slug'          => '5-3-2',
                'created_at'    => $date,
                'updated_at'    => $date,
            ],
            [
                'name'          => '5-4-1',
                'slug'          => '5-4-1',
                'created_at'    => $date,
                'updated_at'    => $date,
            ],
        ]);
    }
}
