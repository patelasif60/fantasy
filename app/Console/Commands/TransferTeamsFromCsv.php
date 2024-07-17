<?php

namespace App\Console\Commands;

use App\Models\Division;
use App\Models\DivisionTeam;
use App\Models\PredefinedCrest;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TransferTeamsFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to migrate teams from CSV file to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Migration of teams started');
        $defaultCrestTeam = PredefinedCrest::where('name', 'Default Crest')->first();

        if (($handle = fopen(database_path().'/seeds/files/transfer_teams.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $managerId = $this->getManagerIdFromMapCsv($data[1]);

                if (! $managerId) {
                    info('LeagueId does not have manager.', ['leagueId' => $data[1]]);
                    continue;
                }

                $divisionId = $this->getDivisionIdFromMapCsv($data[2]);

                if (! $divisionId) {
                    info('Division does not exist.', ['divisionId' => $data[2]]);
                    continue;
                }

                $division = Division::find($divisionId);

                $teamBudget = $division->getOptionValue('pre_season_auction_budget');
                $maxFreePlaces = $division->getOptionValue('max_free_places');
                $isFreeCount = DivisionTeam::where('division_id', $divisionId)->where('is_free', 1)->count();

                $team = Team::create([
                    'name' => string_preg_replace($data[3]),
                    'manager_id' => $managerId,
                    'crest_id' => $defaultCrestTeam->id,
                    'is_approved' => true,
                    'team_budget' => $teamBudget,
                    'uuid' => (string) Str::uuid(),
                ]);
                $team->teamDivision()->attach($divisionId, ['season_id'=> Season::getLatestSeason(), 'is_free'=> false]);
            }

            fclose($handle);

            $this->info('Migration of teams finish');
        }
    }

    private function getManagerIdFromMapCsv($csvId)
    {
        if (($handles = fopen(database_path().'/seeds/files/transfer_user_id_map.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handles, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                if ($data[0] == $csvId) {
                    return $data[1];
                }
            }

            fclose($handles);
        }
    }

    private function getDivisionIdFromMapCsv($csvId)
    {
        if (($handles = fopen(database_path().'/seeds/files/transfer_division_id_map.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handles, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                if ($data[0] == $csvId) {
                    return $data[1];
                }
            }

            fclose($handles);
        }
    }

    private function createDivisionTeams($teamId, $divisionId)
    {
    }

    private function checkNewUserteam($managerId)
    {
        $teams = Team::JOIN('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->where('division_teams.season_id', Season::getPreviousSeason())
            ->where('teams.manager_id', $managerId)
            ->count('division_teams.id');
        if ($teams > 0) {
            return false;
        }

        return true;
    }
}
