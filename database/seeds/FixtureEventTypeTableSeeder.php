<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixtureEventTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        DB::table('fixture_event_type')->insert([
            [
                'name'  => 'Goal',
                'key'   => 'goal',
                'class' => \App\Fixtures\EventType\Goal::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Substitution',
                'key'   => 'substitution',
                'class' => \App\Fixtures\EventType\Substitution::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Yellow card',
                'key'   => 'yellow_card',
                'class' => \App\Fixtures\EventType\YellowCard::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Red card',
                'key'   => 'red_card',
                'class' => \App\Fixtures\EventType\RedCard::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Match start',
                'key'   => 'match_start',
                'class' => \App\Fixtures\EventType\MatchStart::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Match end',
                'key'   => 'match_end',
                'class' => \App\Fixtures\EventType\MatchEnd::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Penalty saved',
                'key'   => 'penalty_saved',
                'class' => \App\Fixtures\EventType\PenaltySaved::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Penalty missed',
                'key'   => 'penalty_missed',
                'class' => \App\Fixtures\EventType\PenaltyMissed::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Team win',
                'key'   => 'team_win',
                'class' => \App\Fixtures\EventType\TeamWin::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Goalkeeper save (TBC)',
                'key'   => 'goalkeeper_save',
                'class' => \App\Fixtures\EventType\GoalkeeperSave::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
            [
                'name'  => 'Own Goal',
                'key'   => 'own_goal',
                'class' => \App\Fixtures\EventType\OwnGoal::class,
                'created_at'=>$date,
                'updated_at'=>$date,
            ],
        ]);
    }
}
