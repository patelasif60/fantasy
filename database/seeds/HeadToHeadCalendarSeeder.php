<?php

use App\Models\HeadToHeadCalendar;
use Illuminate\Database\Seeder;

class HeadToHeadCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calendar = config('head_to_head_calendar');

        foreach ($calendar as $tournament) {
            data_fill($tournament['data'], '*.size', $tournament['division_size']);
            HeadToHeadCalendar::insert($tournament['data']);
        }
    }
}
