<?php

use App\Models\Division;
use App\Models\User;
use App\Services\TeamService;
use Illuminate\Database\Seeder;

class TeamsCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/teams.csv', 'r')) !== false) {
            $flag = true;
            $teamService = app(TeamService::class);

            $crests = $teamService->getPredefinedCrests()->pluck('name', 'id')->toArray();
            $pitches = $teamService->getPitches();

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $name = string_preg_replace($data[0]);

                $manager_id = string_preg_replace($data[1]);
                $user = User::where('email', $manager_id)->first();

                $division_id = string_preg_replace($data[2]);
                $division = Division::where('name', $division_id)->first();

                $crest_id = $crests ? array_rand($crests) : null;
                $pitch_id = $pitches ? array_rand($pitches) : null;

                $teamData = [
                    'name' => $name,
                    'manager_id' => $user ? $user->consumer->id : null,
                    'crest_id' => $crest_id,
                    'pitch_id' => $pitch_id,
                    'is_approved' => true,
                    'division_id' => $division ? $division->id : 0,
                ];

                $teamService->create($teamData);
            }
            fclose($handle);
        }
    }
}
