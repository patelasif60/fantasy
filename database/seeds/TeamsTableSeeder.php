<?php

use App\Enums\SquadSizeEnum;
use App\Models\Consumer;
use App\Models\Division;
use App\Models\DivisionTeam;
use App\Models\Player;
use App\Models\PlayerContract;
use App\Models\Season;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This table seed data into
     * Team
     * DivisionTeam
     * TeamPlayerContract.
     * @return void
     */
    public function run()
    {

        /**
         * The managers for team from consumer.
         */
        $managers = Consumer::pluck('id');
        $sizeOfManager = count($managers);
        /**
         * Get latest seasons.
         */
        $season = Season::orderBy('id', 'desc')->first()->id;

        if ($sizeOfManager > 0) {

            /**
             * Get all Divisions.
             */
            $divisions = Division::orderBy('id')->get();

            foreach ($divisions as $key => $division) {
                $availableManagers = Consumer::pluck('id');

                // Adjust count if division already has teams
                $maxTeams = 16 - $division->divisionTeamsCurrentSeason()->count();
                $alreadySelectedManagers = $division->divisionTeamsCurrentSeason->pluck('manager')->pluck('id')->filter()->values();
                $availableManagers = $availableManagers->diff($alreadySelectedManagers);

                // Remove managers of existing teams from available managers list

                // if ($division->divisionTeamsCurrentSeason()->count()) {
                //     continue;
                // }

                /**
                 * Divison/League can have 1-16 teams
                 * We have taken random (1,16)
                 * So a we will create between random (1,16) team per division.
                 */
                $createTotalTeam = rand(5, $maxTeams);

                for ($b = 0; $b < $createTotalTeam; $b++) {

                    /**
                     * Random manager.
                     */
                    $managerId = Arr::pull($availableManagers, rand(0, count($availableManagers) - 1));
                    $availableManagers = $availableManagers->values();

                    /**
                     * Create a team.
                     */
                    $team = factory(Team::class)->create(['manager_id' => $managerId]);

                    /*
                    * Create a DivisionTeam
                    */

                    DivisionTeam::create([
                        'team_id' => $team->id,
                        'division_id' => $division->id,
                        'season_id'=> $season,
                    ]);

                    /*
                     * Get players from player contract
                     * Only those player which have active contracts
                     * They should not be in any team of current league.
                     */
                    // $totalPlayers = rand(11, 18);

                    // $teamIds = DivisionTeam::where('division_id', $division->id)->pluck('team_id');
                    // $playerIds = TeamPlayerContract::whereIn('team_id', $teamIds)->pluck('player_id');

                    // $centerBacks = PlayerContract::whereNotIn('player_id', $playerIds)->active()->where('position', 'Centre-back (CB)')->limit(4)->get();

                    // $strikers = PlayerContract::whereNotIn('player_id', $playerIds)->active()->where('position', 'Striker (ST)')->limit(2)->get();

                    // $midFielders = PlayerContract::whereNotIn('player_id', $playerIds)->active()->where('position', 'Midfielder (MF)')->limit(4)->get();

                    // $goalKeeper = PlayerContract::whereNotIn('player_id', $playerIds)->active()->where('position', 'Goalkeeper (GK)')->limit(1)->get();

                    // $allPlayers = new Collection;

                    // $allPlayers = $allPlayers->merge($centerBacks);
                    // $allPlayers = $allPlayers->merge($strikers);
                    // $allPlayers = $allPlayers->merge($midFielders);
                    // $allPlayers = $allPlayers->merge($goalKeeper);
                    // $allPlayers = $allPlayers->pluck('player_id');

                    // $playerIds = $allPlayers->merge($playerIds);

                    // $substitutes = PlayerContract::whereNotIn('player_id', $playerIds)->active()->limit($totalPlayers - SquadSizeEnum::SQUAD_LINEUP)->get();

                    // /*
                    // * Create TeamPlayerContract
                    // * Create 13 TeamPlayerContract
                    // * Formations
                    // * 2 Strikers, 4 defenders(centerBacks)
                    // * 1 Goal Keeper, 4 midFielders
                    // * 2 substitutes
                    // */

                    // foreach ($centerBacks as $key => $value) {
                    //     $this->createTeamPlayerContract($team->id, $value->player_id, true);
                    // }

                    // foreach ($strikers as $key => $value) {
                    //     $this->createTeamPlayerContract($team->id, $value->player_id, true);
                    // }

                    // foreach ($midFielders as $key => $value) {
                    //     $this->createTeamPlayerContract($team->id, $value->player_id, true);
                    // }

                    // foreach ($goalKeeper as $key => $value) {
                    //     $this->createTeamPlayerContract($team->id, $value->player_id, true);
                    // }

                    // foreach ($substitutes as $key => $value) {
                    //     $this->createTeamPlayerContract($team->id, $value->player_id, false);
                    // }
                }
            }
        }
    }

    private function createTeamPlayerContract($teamId, $playerId, $isActive)
    {
        TeamPlayerContract::create([
            'team_id' => $teamId,
            'player_id' => $playerId,
            'is_active'=> $isActive,
            'start_date'=> Carbon::now()->format(config('fantasy.db.datetime.format')),
        ]);
    }
}
