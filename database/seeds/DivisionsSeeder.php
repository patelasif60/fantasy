<?php

use App\Models\Consumer;
use App\Models\Division;
use App\Models\DivisionPoint;
use Illuminate\Database\Seeder;

class DivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $position = ['goal', 'assist', 'goal_conceded', 'clean_sheet', 'appearance', 'club_win', 'red_card', 'yellow_card', 'own_goal', 'penalty_missed', 'penalty_save', 'goalkeeper_save_x5'];

        for ($i = 0; $i < 4; $i++) {
            $consumer = Consumer::get()->random();
            $division = factory(Division::class)->create(['chairman_id' => $consumer]);
            $consumer->coChairmenDivisions()->save($division);

            foreach ($position as $key => $value) {
                DivisionPoint::create([
                    'division_id' => $division->id,
                    'events' => $value,
                ]);
            }
        }
        for ($i = 0; $i < 3; $i++) {
            $consumer = Consumer::get()->random();
            $division = factory(Division::class)->create(['chairman_id' => $consumer]);

            foreach ($position as $key => $value) {
                DivisionPoint::create([
                    'division_id' => $division->id,
                    'events' => $value,
                    'goal_keeper' => rand(0, 10),
                    'centre_back' => rand(0, 10),
                    'full_back' => rand(0, 10),
                    'defensive_mid_fielder' => rand(0, 10),
                    'mid_fielder' => rand(0, 10),
                    'striker' => rand(0, 10),
                ]);
            }

            $division = factory(Division::class)->create(['chairman_id' => $division->chairman_id, 'parent_division_id' => $division->id]);
            $consumer->coChairmenDivisions()->save($division);

            foreach ($position as $key => $value) {
                DivisionPoint::create([
                    'division_id' => $division->id,
                    'events' => $value,
                ]);
            }
        }
    }
}
