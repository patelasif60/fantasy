<?php

namespace App\Services;

use App\Models\Consumer;
use App\Models\GameWeek;
use App\Models\ProcupFixture;
use App\Models\Season;
use App\Models\Team;
use App\Repositories\DivisionRepository;
use App\Repositories\ProcupFixtureRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ProcupFixtureService
{
    /**
     * The procup phase repository instance.
     *
     * @var repository
     */
    protected $repository;

    /**
     * The division repository instance.
     *
     * @var
     */
    protected $divisionRepository;

    /**
     * The seacon variable.
     *
     * @var season
     */
    protected $season;

    /**
     * The procup fixture model instance.
     *
     * @var procupFixture
     */
    private $procupFixture;

    /**
     * Create a new service instance.
     *
     * @param ProcupPhaseRepository $repository
     */
    public function __construct(ProcupFixtureRepository $repository, ProcupFixture $procupFixture, DivisionRepository $divisionRepository)
    {
        $this->repository = $repository;
        $this->procupFixture = $procupFixture;
        $this->divisionRepository = $divisionRepository;
    }

    public function getFirstGameWeekByGroupSize($date = null)
    {
        $proCupNumberOfTeams = GameWeek::$proCupNumberOfTeams;
        $return = [];
        foreach ($proCupNumberOfTeams as $size) {
            $return[$size] = $this->repository->getFirstGameWeekByGroupSize($date, $size);
        }

        return $return;
    }

    public function manageGroups($gameweek)
    {
        $seasonDivisions = $this->repository->getDivisionGroups();
        $leagueTeamsGroup = $this->leagueTeamsGroup($seasonDivisions);
        $groups = $this->createByesMatches($leagueTeamsGroup);

        if ($groups) {
            return $this->createFixture($gameweek, $groups);
        } else {
            return false;
        }
    }

    private function leagueTeamsGroup($seasonDivisions)
    {
        $leagueTeamsGroup = [];
        foreach ($seasonDivisions as $key => $value) {
            if ($value->division_teams_count >= 5 && $value->division_teams_count <= 7) {
                $leagueTeamsGroup[7][$value->id] = $value->divisionTeams->pluck('id');
            } elseif ($value->division_teams_count >= 8 && $value->division_teams_count <= 10) {
                $leagueTeamsGroup[10][$value->id] = $value->divisionTeams->pluck('id');
            } elseif ($value->division_teams_count >= 11 && $value->division_teams_count <= 13) {
                $leagueTeamsGroup[13][$value->id] = $value->divisionTeams->pluck('id');
            } elseif ($value->division_teams_count >= 14 && $value->division_teams_count <= 16) {
                $leagueTeamsGroup[16][$value->id] = $value->divisionTeams->pluck('id');
            }
        }

        return $leagueTeamsGroup;
    }

    private function createByesMatches($leagueTeamsGroup)
    {
        $groups = [];
        foreach ($leagueTeamsGroup as $k => $team) {
            $groupTeams = collect($team)->flatten()->shuffle();
            $near_power = get_nearest_power_value($groupTeams->count());
            $teams_to_be_eliminate = $groupTeams->count() - $near_power;
            $byes_team_count = $groupTeams->count() - ($teams_to_be_eliminate * 2);

            $newGroupTeams = collect();
            $groups[$k]['byes_teams'] = $groupTeams->random($byes_team_count);
            if ($teams_to_be_eliminate != 0) {
                $newGroupTeams = $groupTeams->diff($groups[$k]['byes_teams']);
            } elseif ($byes_team_count == $near_power) {
                $newGroupTeams = $groupTeams;
            }
            $groups[$k]['knockout'] = $newGroupTeams->chunk(2)->toArray();
        }

        return $groups;
    }

    private function createFixture($gameweek, $groups)
    {
        foreach ($gameweek as $key => $phase) {
            $sizePhase = $phase->proCupPhases->keyBy('size');
            $phase = $sizePhase[$key];

            $groupFixtures = collect();
            if (isset($groups[$phase['size']]['byes_teams']) && ! empty($groups[$phase['size']]['byes_teams'])) { //entry for byes_teams
                $byes = $groups[$phase['size']]['byes_teams'];
                foreach ($byes as $bye) {
                    $groupFixtures[] = [
                        'season_id' => Season::getLatestSeason(),
                        'procup_phase_id' => $phase['id'],
                        'size' => $phase['size'],
                        'home' => $bye,
                        'winner' => $bye,
                        'created_at' =>now()->format(config('fantasy.db.datetime.format')),
                        'updated_at' =>now()->format(config('fantasy.db.datetime.format')),
                    ];
                    // $this->create($groupFixtures);
                }

                foreach ($groupFixtures->chunk(30)->toArray() as $fixtures) {
                    $this->createMultiple($fixtures);
                }
            }

            $groupFixtures = collect();
            if (isset($groups[$phase['size']]['knockout']) && ! empty($groups[$phase['size']]['knockout'])) { //entry for team play for knockout
                $knockoutTeams = $groups[$phase['size']]['knockout'];
                foreach ($knockoutTeams as $knockoutTeam) {
                    $knockoutTeam = collect($knockoutTeam)->values(); // reverse keys
                    $groupFixtures[] = [
                        'season_id' => Season::getLatestSeason(),
                        'procup_phase_id' => $phase['id'],
                        'size' => $phase['size'],
                        'home' => $knockoutTeam[0],
                        'away' => $knockoutTeam[1],
                        'created_at' =>now()->format(config('fantasy.db.datetime.format')),
                        'updated_at' =>now()->format(config('fantasy.db.datetime.format')),
                    ];
                    // $this->create($groupFixtures);
                }
                foreach ($groupFixtures->chunk(30)->toArray() as $fixtures) {
                    $this->createMultiple($fixtures);
                }
            }
        }
    }

    public function createMultiple($fixtures)
    {
        $this->repository->createMultiple($fixtures);
    }

    public function createNextFixtures($date = null)
    {
        return $this->createNextPhases($date);
    }

    public function createNextPhases($date)
    {
        // get current gameweek phases
        $previousGameweeks = [];
        foreach (GameWeek::$proCupNumberOfTeams as $size) {
            $previousGameweeks[$size] = $this->repository->getRunningGameWeek($date, $size);
        }

        // get next fixture from current phases
        $nextGameweeks = [];
        foreach ($previousGameweeks as $size => $runningGameweek) {
            if (isset($runningGameweek->end)) {
                $nextGameweeks[$size] = $this->repository->getNextGameWeek($runningGameweek->end, $size);
            }
        }
        $this->createNextFixure($previousGameweeks, $nextGameweeks);
    }

    public function createNextFixure($previousGameweeks, $nextGameweeks)
    {
        foreach ($nextGameweeks as $key => $nextGameweek) {
            if (isset($nextGameweek->proCupPhases)) {
                $data = $previousGameweeks[$key]->proCupPhases->where('size', $key)->pluck('id');
                $phase = $nextGameweek->proCupPhases->where('size', $key)->values();
                $winnerProcupFixtures = $this->repository->getWinnerProcupFixtures($key, $data);
                $fixtures = $winnerProcupFixtures->shuffle()->chunk(2);

                $this->createNextFixture($fixtures, $phase);
            }
        }
    }

    public function createNextFixture($fixtures, $phase)
    {
        $groupFixtures = collect();
        foreach ($fixtures as $fixturesKey => $fixture) {
            $teams = $fixture->values();
            if (isset($teams[1])) {
                $groupFixtures[] = [
                    'season_id' => Season::getLatestSeason(),
                    'procup_phase_id' => Arr::get($phase, '0.id'),
                    'size' => Arr::get($phase, '0.size'),
                    'home' => $teams[0],
                    'away' => $teams[1],
                    'created_at' =>now()->format(config('fantasy.db.datetime.format')),
                    'updated_at' =>now()->format(config('fantasy.db.datetime.format')),
                ];
                // $this->repository->create($data);
            }
        }

        foreach ($groupFixtures->chunk(30)->toArray() as $fixtures) {
            $this->createMultiple($fixtures);
        }
    }

    public function getUpCommingGameWeek($date = null)
    {
        $proCupNumberOfTeams = GameWeek::$proCupNumberOfTeams;

        $return = [];
        foreach ($proCupNumberOfTeams as $size) {
            $return[$size] = $this->repository->getUpCommingGameWeek($date, $size);
        }

        return $return;
    }

    public function getLastestEndGameWeek($date = null)
    {
        // use for update records
        return $this->repository->getLastestEndGameWeek($date);
    }

    public function create($data)
    {
        return $this->repository->create($data);
    }

    public function updateFixtures($gameweek)
    {
        $proCupPhases = Arr::get($gameweek, 'proCupPhases');

        foreach ($proCupPhases as $proCupPhase) {
            $teams = collect();
            $totalTeams = $proCupPhase->notWinnerFixtures()->get()->filter(function ($query) use ($teams) {
                $teams->push($query->home);
                $teams->push($query->away);
            });

            // get size/groupsize wise winner points
            $data['startDate'] = $gameweek->start;
            $data['endDate'] = $gameweek->end;
            $data['teams'] = $teams;
            $teamsPoints = $this->getTeamsScores($data);
            $this->updateFixtureWinner($proCupPhase, $teamsPoints);
        }
    }

    private function getTeamsScores($data)
    {
        return $this->repository->getTeamsScores($data);
    }

    private function updateFixtureWinner($procupFixture, $teamsPoints)
    {
        $fixtures = $procupFixture->notWinnerFixtures()->get();
        foreach ($fixtures as $k => $fixture) { // decide winner and update
            $data = [];
            $data['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
            if (Arr::has($teamsPoints, "$fixture->home") && Arr::has($teamsPoints, "$fixture->away")) {
                $data['home_points'] = Arr::get($teamsPoints, "$fixture->home.total_point", 0);
                $data['away_points'] = Arr::get($teamsPoints, "$fixture->away.total_point", 0);

                // $data['home_points'] = Arr::get($teamsPoints,"$fixture->home.total_point",rand(1,9));
                // $data['away_points'] = Arr::get($teamsPoints,"$fixture->away.total_point",rand(1,9));

                if ($data['home_points'] > $data['away_points']) { // home win
                    $data['winner'] = $fixture->home;
                } elseif ($data['home_points'] < $data['away_points']) { // away win
                    $data['winner'] = $fixture->away;
                } else { // tie match (as per issue tracker sheet issue no 29 reponse)
                    if (Arr::get($teamsPoints, "$fixture->home.total_goal") != Arr::get($teamsPoints, "$fixture->away.total_goal")) { // take priority to goals scored
                        if (Arr::get($teamsPoints, "$fixture->home.total_goal") > Arr::get($teamsPoints, "$fixture->away.total_goal")) {
                            $data['winner'] = $fixture->home;
                        } else {
                            $data['winner'] = $fixture->away;
                        }
                    } elseif (Arr::get($teamsPoints, "$fixture->home.total_assist") != Arr::get($teamsPoints, "$fixture->away.total_assist")) { // take 2nd priority to assist
                        if (Arr::get($teamsPoints, "$fixture->home.total_assist") > Arr::get($teamsPoints, "$fixture->away.total_assist")) {
                            $data['winner'] = $fixture->home;
                        } else {
                            $data['winner'] = $fixture->away;
                        }
                    } else { // alphabatical order (team name wise)
                        $homeTeam = Arr::get($teamsPoints, "$fixture->home.teamName");
                        $awayTeam = Arr::get($teamsPoints, "$fixture->away.teamName");
                        if (! strcmp($homeTeam, $awayTeam)) {
                            $data['winner'] = $fixture->home;
                        } else {
                            $data['winner'] = $fixture->away;
                        }
                    }
                }
            }
            $this->update($fixture, $data);
        }

        return true;
    }

    public function update($fixture, $data)
    {
        return $this->repository->update($fixture, $data);
    }

    public function getPhases($division, $consumer)
    {
        return $this->repository->getPhases($division, $consumer);
    }

    public function getPhaseFixtures($phase, $division, $consumer)
    {
        $proCupPhses = $this->repository->getPhaseFixtures($phase, $division, $consumer);
        $managerTeams = Consumer::find(auth()->user()->consumer->id);
        if (Arr::has($managerTeams, 'teams')) {
            $managerTeams = $managerTeams->teams->pluck('id')->toArray();
        } else {
            $managerTeams = [];
        }

        $teams = [];
        foreach ($proCupPhses as $key => $proCupPhse) {
            array_push($teams, $proCupPhse->home);
            if (! empty($proCupPhse->away)) {
                array_push($teams, $proCupPhse->away);
            }
        }

        $teams = $this->repository->getTeams($teams);

        $response = [];
        foreach ($proCupPhses as $key => $proCupPhse) {
            $data['phase_id'] = $proCupPhse['procup_phase_id'];
            $data['procup_fixture_id'] = $proCupPhse['procup_fixture_id'];
            $data['gameweek_start'] = $proCupPhse['start'];
            $data['gameweek_end'] = $proCupPhse['end'];
            $data['gameweek'] = Carbon::parse($proCupPhse['start'])->format(config('fantasy.view.day_month')).' - '.Carbon::parse($proCupPhse['end'])->format(config('fantasy.view.day_month_year'));
            $data['away_team_id'] = '';
            $data['away_team_name'] = '';
            $data['away_points'] = '-';
            $data['away_manager'] = '';
            if (in_array($proCupPhse['home'], $managerTeams)) {
                $data['home_team_id'] = $proCupPhse['home'];
                $data['home_team_name'] = $teams[$proCupPhse['home']]['name'];
                $id = $proCupPhse['home'];
                $manager = Arr::get($teams, "$id.consumer.user");
                $data['home_manager'] = $manager['first_name'].' '.$manager['last_name'];
                $data['home_points'] = $proCupPhse['home_points'];
                // $data['winner'] = $proCupPhse['home'];
                if (! empty($proCupPhse['away'])) {
                    $data['away_team_id'] = $proCupPhse['away'];
                    $data['away_team_name'] = $teams[$proCupPhse['away']]['name'];
                    $id = $proCupPhse['away'];
                    $manager = Arr::get($teams, "$id.consumer.user");
                    $data['away_manager'] = $manager['first_name'].' '.$manager['last_name'];
                    $data['away_points'] = $proCupPhse['away_points'];
                    // $data['winner'] = ($proCupPhse['away_points'] > $proCupPhse['home_points'] ? $proCupPhse['away'] : $proCupPhse['home'] );
                }
            } elseif (in_array($proCupPhse['away'], $managerTeams)) {
                $data['home_team_id'] = $proCupPhse['away'];
                $data['home_team_name'] = $teams[$proCupPhse['away']]['name'];
                $id = $proCupPhse['away'];
                $manager = Arr::get($teams, "$id.consumer.user");
                $data['home_manager'] = $manager['first_name'].' '.$manager['last_name'];
                $data['home_points'] = $proCupPhse['away_points'];
                // $data['winner'] = $proCupPhse['away'];

                $data['away_team_id'] = $proCupPhse['home'];
                $data['away_team_name'] = $teams[$proCupPhse['home']]['name'];
                $id = $proCupPhse['home'];
                $manager = Arr::get($teams, "$id.consumer.user");
                $data['away_manager'] = $manager['first_name'].' '.$manager['last_name'];
                $data['away_points'] = $proCupPhse['home_points'];
            }
            // $data['winner'] = ($proCupPhse['away_points'] > $proCupPhse['home_points'] ? $proCupPhse['home'] : $proCupPhse['home'] );

            $response[] = $data;
        }

        return $response;
    }
}
