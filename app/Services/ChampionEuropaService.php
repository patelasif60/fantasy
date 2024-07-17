<?php

namespace App\Services;

use App\Enums\EuropeanPhasesNameEnum;
use App\Models\Consumer;
use App\Models\Season;
use App\Repositories\ChampionEuropaRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

// use Illuminate\Support\Carbon;

class ChampionEuropaService
{
    const CHAMPIONS_LEAGUE_TEAM = 'champions_league_team';
    const EUROPA_LEAGUE_TEAM_1 = 'europa_league_team_1';
    const EUROPA_LEAGUE_TEAM_2 = 'europa_league_team_2';

    /**
     * The competition repository instance.
     *
     * @var CompetitionRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param CompetitionRepository $repository
     */
    public function __construct(ChampionEuropaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createFixtures()
    {
        $fixtures = collect($this->setFixtures());
        if ($fixtures->has('championFixtures') && count($fixtures['championFixtures'])) {
            $championFixtures = collect($fixtures['championFixtures'])->chunk(20);
            foreach ($championFixtures as $chunk) {
                $this->repository->create($chunk->toArray());
            }
        }

        if ($fixtures->has('championsBye') && count($fixtures['championsBye'])) {
            $this->repository->create($fixtures['championsBye']);
        }

        if ($fixtures->has('europaFixtures') && count($fixtures['europaFixtures'])) {
            $europaFixtures = collect($fixtures['europaFixtures'])->chunk(20);
            foreach ($europaFixtures as $chunk) {
                $this->repository->create($chunk->toArray());
            }
        }

        if ($fixtures->has('europaBye') && count($fixtures['europaBye'])) {
            $this->repository->create($fixtures['europaBye']);
        }
    }

    public function setFixtures()
    {
        $season = Season::getPreviousSeason();
        if (config('fantasy.only_one_time_for_champion_euroapa')) {
            /**
             * Note as we are in between season
             * and we don't have previous season.
             * so we are managing both after season
             * + Between season work.
             */
            $season = Season::getLatestSeason();
        }

        $competitionTeams['champions'] = $this->repository->getChampionEuropaTeams($season, 'champions_league_team')->toArray();

        $europaTeam1 = $this->repository->getChampionEuropaTeams($season, 'europa_league_team_1');
        $europaTeam2 = $this->repository->getChampionEuropaTeams($season, 'europa_league_team_2');

        $competitionTeams['europa'] = $europaTeam1->merge($europaTeam2)->toArray();

        $championsByeCnt = count($competitionTeams['champions']) % 4;
        $europaByeCnt = count($competitionTeams['europa']) % 4;

        $championsBye = [];
        $europaBye = [];
        if ($championsByeCnt != 0) {
            $data = $this->setGroupAndByes($competitionTeams['champions'], $championsByeCnt, EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
            $competitionTeams['champions'] = $data['group'];
            $championsBye = $data['groupBye'];
        }
        if ($europaByeCnt != 0) {
            $data = $this->setGroupAndByes($competitionTeams['europa'], $europaByeCnt, EuropeanPhasesNameEnum::EUROPA_LEAGUE);
            $competitionTeams['europa'] = $data['group'];
            $europaBye = $data['groupBye'];
        }

        $championGroups = $this->setGroups($competitionTeams['champions']);
        $europaGroups = $this->setGroups($competitionTeams['europa']);

        $data = [];
        $data['championFixtures'] = $this->setGroupFixtures($championGroups, EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
        $data['championsBye'] = $championsBye;
        $data['europaFixtures'] = $this->setGroupFixtures($europaGroups, EuropeanPhasesNameEnum::EUROPA_LEAGUE);
        $data['europaBye'] = $europaBye;

        return $data;
    }

    private function setGroupAndByes($group, $totalTeams, $tournament)
    {
        $season = Season::getLatestSeason();
        $group = collect($group)->sort();
        $groupBye = $group->slice(-$totalTeams);
        $fixtures = [];
        if ($groupBye->count()) {
            $phase = $this->repository->getGameWeekPhases($season, $tournament, 'Knockout');
            if ($phase->count()) {
                foreach ($groupBye as $key => $value) {
                    $tempFixture['european_phase_id'] = $phase[0]->id;
                    $tempFixture['tournament_type'] = $tournament;
                    $tempFixture['season_id'] = $season;
                    $tempFixture['home'] = $value;
                    $tempFixture['bye_type'] = 'group';
                    $tempFixture['created_at'] = now()->format(config('fantasy.db.datetime.format'));
                    $tempFixture['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
                    $fixtures[] = $tempFixture;
                }
            }
        }
        $data['groupBye'] = $fixtures;

        $data['group'] = $group->slice(0, -$totalTeams);

        return $data;
    }

    private function setGroups($group)
    {
        return collect($group)->shuffle()->chunk(4);
    }

    private function setGroupFixtures($group, $tournament)
    {
        $season = Season::getLatestSeason();
        $fixtures = [];
        $phase = [];
        $phase = $this->repository->getGameWeekPhases($season, $tournament, 'Group');

        if ($phase->count() == 6) {
            foreach ($group as $key => $value) {
                $teams = $value->values();
                $tempFixture['created_at'] = now()->format(config('fantasy.db.datetime.format'));
                $tempFixture['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
                $tempFixture['season_id'] = $season;
                $tempFixture['tournament_type'] = $tournament;
                $tempFixture['group_no'] = ($key + 1);
                $tempFixture['european_phase_id'] = $phase[0]->id;
                $tempFixture['home'] = $teams[0];
                $tempFixture['away'] = $teams[1];
                $fixtures[] = $tempFixture;
                $tempFixture['home'] = $teams[2];
                $tempFixture['away'] = $teams[3];
                $fixtures[] = $tempFixture;

                $tempFixture['european_phase_id'] = $phase[1]->id;
                $tempFixture['home'] = $teams[0];
                $tempFixture['away'] = $teams[2];
                $fixtures[] = $tempFixture;
                $tempFixture['home'] = $teams[1];
                $tempFixture['away'] = $teams[3];
                $fixtures[] = $tempFixture;

                $tempFixture['european_phase_id'] = $phase[2]->id;
                $tempFixture['home'] = $teams[0];
                $tempFixture['away'] = $teams[3];
                $fixtures[] = $tempFixture;
                $tempFixture['home'] = $teams[1];
                $tempFixture['away'] = $teams[2];
                $fixtures[] = $tempFixture;

                $tempFixture['european_phase_id'] = $phase[3]->id;
                $tempFixture['home'] = $teams[3];
                $tempFixture['away'] = $teams[2];
                $fixtures[] = $tempFixture;
                $tempFixture['home'] = $teams[1];
                $tempFixture['away'] = $teams[0];
                $fixtures[] = $tempFixture;

                $tempFixture['european_phase_id'] = $phase[4]->id;
                $tempFixture['home'] = $teams[3];
                $tempFixture['away'] = $teams[1];
                $fixtures[] = $tempFixture;
                $tempFixture['home'] = $teams[2];
                $tempFixture['away'] = $teams[0];
                $fixtures[] = $tempFixture;

                $tempFixture['european_phase_id'] = $phase[5]->id;
                $tempFixture['home'] = $teams[3];
                $tempFixture['away'] = $teams[0];
                $fixtures[] = $tempFixture;
                $tempFixture['home'] = $teams[2];
                $tempFixture['away'] = $teams[1];
                $fixtures[] = $tempFixture;
            }
        }

        return $fixtures;
    }

    public function getPreviousGameWeek($date, $tournament)
    {
        $gameWeek = $this->repository->getPreviousGameWeek($date, $tournament);
        if (! is_null($gameWeek) && $gameWeek->europeanPhases->count()) {
            return $gameWeek;
        }

        return false;
    }

    public function updateTournamentFixtures($gameWeek)
    {
        $championsEuropaGameWeek = $gameWeek->europeanPhases;

        foreach ($championsEuropaGameWeek as $key => $value) {
            $teams = collect();
            $teams->push($value->notChampionEuropaWinnerFixtures()->pluck('home'));
            $teams->push($value->notChampionEuropaWinnerFixtures()->pluck('away'));
            $teams = $teams->flatten();
            $data['startDate'] = $gameWeek->start;
            $data['endDate'] = $gameWeek->end;
            $data['teams'] = $teams;
            $teamsPoints = $this->repository->getTeamsScores($data);
            if (Str::contains($value->name, 'Knockout')) {
                $this->updateKnockoutFixtures($value->notChampionEuropaWinnerFixtures()->get(), $teamsPoints);
                $this->createNextFixtures($gameWeek);
            } else {
                $this->updateFixtures($value->notChampionEuropaWinnerFixtures()->get(), $teamsPoints);
            }
        }
        if ($championsEuropaGameWeek[0]->name == 'Group stage - game 6') {
            $knockoutsPreviousGameWeek = $this->repository->getFirstKnockout($gameWeek->europeanPhases[0]->id, $gameWeek->europeanPhases[0]->tournament, 'Knock');
            $this->createFirstChamionEuropaKnockoutFixtures($knockoutsPreviousGameWeek, $gameWeek->season_id, $gameWeek->europeanPhases[0]->tournament);
        }
    }

    private function updateFixtures($fixtures, $teamsPoints)
    {
        foreach ($fixtures as $k => $fixture) {
            $data = [];
            if (Arr::has($teamsPoints, "$fixture->home") && Arr::has($teamsPoints, "$fixture->away")) {
                $data['home_points'] = Arr::get($teamsPoints, "$fixture->home.total_point", 0);
                $data['away_points'] = Arr::get($teamsPoints, "$fixture->away.total_point", 0);
                if ($data['home_points'] >= $data['away_points']) {
                    $data['winner'] = $fixture->home;
                } else {
                    $data['winner'] = $fixture->away;
                }
            }
            $this->repository->update($fixture, $data);
        }
    }

    private function updateKnockoutFixtures($fixtures, $teamsPoints)
    {
        foreach ($fixtures as $k => $fixture) {
            // decide winner and update
            $data = [];
            if (Arr::has($teamsPoints, "$fixture->home") && Arr::has($teamsPoints, "$fixture->away")) {
                $data['home_points'] = Arr::get($teamsPoints, "$fixture->home.total_point", 0);
                $data['away_points'] = Arr::get($teamsPoints, "$fixture->away.total_point", 0);

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
            $this->repository->update($fixture, $data);
        }
    }

    public function getPreviousKnockoutsGameWeek($date, $tournament)
    {
        $gameWeek = $this->repository->getPreviousKnockoutsGameWeek($date, $tournament);
        if (! is_null($gameWeek) && $gameWeek->europeanPhases->count()) {
            return $gameWeek;
        }

        return false;
    }

    public function createFirstChamionEuropaKnockoutFixtures($knockoutsPreviousGameWeek, $season, $tournament)
    {
        $teams = $this->getGroupWinners($season, $tournament);
        $allTeams = collect();
        foreach ($teams as $key => $value) {
            $allTeams = $allTeams->merge($value);
        }
        //dd($allTeams);
        // $byeTeams = $this->getGroupByeTeams($season, $tournament);
        // $allTeams = collect();
        // $allTeams = $allTeams->merge($byeTeams);
        // $firstWinners = $teams->collapse()->nth(2);
        // $allTeams = $allTeams->merge($firstWinners);
        // $secondWinners = $teams->collapse()->nth(2, 1);
        // $allTeams = $allTeams->merge($secondWinners);

        $groups = $this->createFirstKnockoutMatches($allTeams);
        if ($groups) {
            return $this->createFirstKnockoutFixtures($knockoutsPreviousGameWeek, $groups, $tournament);
        } else {
            return false;
        }
    }

    public function getGroupWinners($season, $tournament)
    {
        return $knockoutTeams = $this->calculateGroupPoints($season, $tournament);
    }

    public function calculateGroupPoints($season, $tournament)
    {
        $away = $this->repository->calculateGroupAwayPoints($season, $tournament);
        $home = $this->repository->calculateGroupHomePoints($season, $tournament);

        $teamPoints = $this->sortTeamByPoints($this->combineHomeAwayTeams($away, $home));

        return $this->getKnockOutTeams($teamPoints, $season, $tournament, 'Group');
    }

    public function combineHomeAwayTeams($away, $home)
    {
        $teamCombinePoints = [];
        foreach ($away as $awayKey => $awayValue) {
            foreach ($home as $homeKey => $homeValue) {
                if ($awayValue->away == $homeValue->home) {
                    $teamCombinePoints[$awayValue->group_no][$homeValue->home] = $awayValue->points + $homeValue->points;
                }
            }
        }

        return $teamCombinePoints;
    }

    public function sortTeamByPoints($teamCombinePoints)
    {
        $topTeams = [];
        foreach ($teamCombinePoints as $key => $value) {
            arsort($value);
            $topTeams[$key] = $value;
        }

        return $topTeams;
    }

    public function getKnockOutTeams($topTeams, $season, $tournament, $group)
    {
        $knockoutTeams = collect();
        $phase = $this->repository->getGameWeekPhases($season, $tournament, $group);
        $maxgroupID = $this->repository->maxgroupID($season);
        for ($group_no = 1; $group_no <= $maxgroupID->max_group_no; $group_no++) {
            $data['group'] = $group_no;
            $knockoutTeams = array_slice($this->getChampionEuropaGroupStandings('', $data, $tournament), 0, 2);
            if ($knockoutTeams == null) {
                break;
            }
            $knockoutTeam[$group_no] = collect();
            $knockoutTeam[$group_no]->push($knockoutTeams[0]['team_id']);
            $knockoutTeam[$group_no]->push($knockoutTeams[1]['team_id']);
        }

        return $knockoutTeam;
        foreach ($topTeams as $key => $value) {
            //  dd($value);
            $knockoutTeams[$key] = collect();
            $teams = collect($value);
            $value = $teams->values();
            $teams = $teams->keys();

            $data['startDate'] = $phase->first()->GameWeek->start;
            $data['endDate'] = $phase->last()->GameWeek->end;
            $data['teams'] = $teams;
            $teamsPoints = $this->repository->getTeamsScores($data);
            $data = [];

            if ($value[0] == $value[1] && $value[0] == $value[2] && $value[0] == $value[3]) {
                //$knockoutTeams[$key]->push($teamsPoints[0]->teamId);
                //$knockoutTeams[$key]->push($teamsPoints[1]->teamId);
                //to get second record used slice.
                $knockoutTeams[$key]->push($teamsPoints->first()->teamId);
                $knockoutTeams[$key]->push($teamsPoints->slice(1, 1)->first()->teamId);
            } elseif ($value[0] == $value[1] && $value[0] == $value[2]) {
                $knockoutTeams[$key]->push($teamsPoints[0]->teamId);
                $knockoutTeams[$key]->push($teamsPoints[1]->teamId);
            } elseif ($value[1] == $value[2] && $value[1] == $value[3]) {
                $knockoutTeams[$key]->push($teams[0]);
                $knockoutTeams[$key]->push($teamsPoints->first()->teamId);
            } elseif ($value[1] == $value[2]) {
                $knockoutTeams[$key]->push($teams[0]);
                $knockoutTeams[$key]->push($teamsPoints->first()->teamId);
            } else {
                $knockoutTeams[$key]->push($teams[0]);
                $knockoutTeams[$key]->push($teams[1]);
            }
        }
        //dd($knockoutTeams);
        return $knockoutTeams;
    }

    private function createFirstKnockoutMatches($teams)
    {
        $groups = collect();
        $groups->byes_teams = collect();
        $groups->knockout = collect();
        $near_power = get_nearest_power_value($teams->count());
        $teams_to_be_eliminate = $teams->count() - $near_power;
        $byes_team_count = $teams->count() - ($teams_to_be_eliminate * 2);

        if ($teams_to_be_eliminate != 0) {
            $groups->byes_teams = $teams->diff($teams->slice($byes_team_count));
            $groups->knockout = $teams->slice($byes_team_count)->shuffle()->chunk(2);
        } elseif ($byes_team_count == $near_power) {
            $groups->knockout = $teams->shuffle()->chunk(2);
        }

        return $groups;
    }

    public function getGroupByeTeams($season, $tournament)
    {
        return $this->repository->getGroupByeTeams($season, $tournament);
    }

    public function createFirstKnockoutFixtures($europeanPhases, $groups, $tournament)
    {
        if ($groups->byes_teams->count()) {
            $fixtures = [];
            foreach ($groups->byes_teams as $key => $value) {
                $tempFixture['european_phase_id'] = $europeanPhases->id;
                $tempFixture['tournament_type'] = $europeanPhases->tournament;
                $tempFixture['season_id'] = $europeanPhases->gameWeek->season_id;
                $tempFixture['home'] = $value;
                $tempFixture['winner'] = $value;
                $tempFixture['bye_type'] = 'knockout';
                $tempFixture['created_at'] = now()->format(config('fantasy.db.datetime.format'));
                $tempFixture['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
                $fixtures[] = $tempFixture;
            }
            $this->repository->create($fixtures);
        }

        if ($groups->knockout->count()) {
            $fixtures = [];
            $tempFixture = [];

            $tempFixture['european_phase_id'] = $europeanPhases->id;
            $tempFixture['tournament_type'] = $europeanPhases->tournament;
            $tempFixture['season_id'] = $europeanPhases->gameWeek->season_id;
            foreach ($groups->knockout as $key => $value) {
                $team = $value->values();
                $tempFixture['home'] = $team[0];
                $tempFixture['away'] = $team[1];
                $tempFixture['created_at'] = now()->format(config('fantasy.db.datetime.format'));
                $tempFixture['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
                $fixtures[] = $tempFixture;
            }
            $this->repository->create($fixtures);
        }
    }

    public function createNextFixtures($gameWeek)
    {
        $fixtures = $this->repository->getWinnerFixtures($gameWeek->europeanPhases[0]->id);
        if ($fixtures->count() > 1) {
            $fixtures = $fixtures->shuffle()->chunk(2);
            $europeanPhases = $this->repository->getFirstKnockout($gameWeek->europeanPhases[0]->id, $gameWeek->europeanPhases[0]->tournament, 'Knock');
            $this->createNextFixture($fixtures, $europeanPhases);
        }
    }

    public function createNextFixture($fixtures, $europeanPhases)
    {
        $data = collect();
        foreach ($fixtures as $fixturesKey => $fixture) {
            $teams = $fixture->values();
            if (Arr::get($teams, 1)) {
                $tempData['european_phase_id'] = $europeanPhases->id;
                $tempData['tournament_type'] = $europeanPhases->tournament;
                $tempData['season_id'] = $europeanPhases->gameWeek->season_id;
                $tempData['home'] = $teams[0];
                $tempData['away'] = $teams[1];
                $tempData['created_at'] = now()->format(config('fantasy.db.datetime.format'));
                $tempData['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
                $data[] = $tempData;
            }
        }
        foreach ($data->chunk(30)->toArray() as $fixtures) {
            $this->repository->create($fixtures);
        }
    }

    public function getGetRunningGroupPhase($groupStages, $date = null)
    {
        // $date = Carbon::parse('2018-11-28');
        if (! $date) {
            $date = now()->format(config('fantasy.db.date.format'));
        }

        $runningGameweek = collect();
        if ($groupStages->count()) { // selest default group match with object range
            foreach ($groupStages as $key => $groupStage) {
                if ($date >= $groupStage->start && $date <= $groupStage->end) {
                    $runningGameweek = $groupStage;
                    break;
                }
            }
        }

        if (! $runningGameweek->count()) { // if no match found then take last
            $runningGameweek = $groupStages->last();
        }

        $data['phase'] = Arr::get($runningGameweek, 'id', '');
        $data['group'] = Arr::get($runningGameweek, 'group_no', '');

        return $data;
    }

    public function getTeams($teams = [])
    {
        return $this->repository->getTeams($teams);
    }

    public function getChampionEuropaPhases($division, $consumer, $tournament)
    {
        return $this->repository->getChampionEuropaPhases($division, $consumer, $tournament);
    }

    public function getChampionEuropaTeamPhases($division, $consumer, $tournament, $europaType)
    {
        return $this->repository->getChampionEuropaTeamPhases($division, $consumer, $tournament, $europaType);
    }

    public function getGroup($division, $tournament, $consumer)
    {
        // $consumer = auth()->user()->consumer;
        $groups = $this->repository->getChampionEuropaPhases($division, $consumer, $tournament);

        $data['group'] = null;
        if ($groups->count()) {
            $data['group'] = $groups->first()['group_no'];
        }

        return $data['group'];
    }

    public function getChampionEuropaPhaseFixtures($division, $data, $tournament)
    {
        $consumer = auth()->user()->consumer;

        $data['consumer'] = $this->getManger($division, $tournament);
        $europeanPhases = $this->repository->getChampionEuropaPhaseFixtures($data, $division, $tournament);
        // $managerTeams = Consumer::find(auth()->user()->consumer->id);
        // if (Arr::has($managerTeams, 'teams')) {
        //     $managerTeams = $managerTeams->teams->pluck('id')->toArray();
        // } else {
        //     $managerTeams = [];
        // }

        $teams = [];
        foreach ($europeanPhases as $key => $europeanPhase) {
            array_push($teams, $europeanPhase->home);
            if (! empty($europeanPhase->away)) {
                array_push($teams, $europeanPhase->away);
            }
        }

        $teams = $this->repository->getTeams($teams);

        $response = [];
        foreach ($europeanPhases as $key => $europeanPhase) {
            $data['start'] = $europeanPhase['start'];
            $data['end'] = $europeanPhase['end'];
            $data['phase_id'] = $europeanPhase['european_phase_id'];
            $data['champion_europa_fixture_id'] = $europeanPhase['champion_europa_fixture_id'];
            $data['home'] = $europeanPhase['away'];
            $data['home_team_name'] = isset($teams[$europeanPhase['away']]) ? $teams[$europeanPhase['away']]['name'] : '';
            $id = $europeanPhase['away'];
            $manager = Arr::get($teams, "$id.consumer.user");
            $data['home_manager'] = $manager['first_name'].' '.$manager['last_name'];
            $data['home_manager_id'] = $manager['id'];
            $data['home_points'] = $europeanPhase['away_points'];

            $data['away'] = $europeanPhase['home'];
            $data['away_team_name'] = isset($teams[$europeanPhase['home']]) ? $teams[$europeanPhase['home']]['name'] : '';
            $id = $europeanPhase['home'];
            $manager = Arr::get($teams, "$id.consumer.user");
            $data['away_manager'] = $manager['first_name'].' '.$manager['last_name'];
            $data['away_manager_id'] = $manager['id'];
            $data['away_points'] = $europeanPhase['home_points'];
            $data['gameweek'] = carbon_format_to_view_date($europeanPhase['start']).' to '.carbon_format_to_view_date($europeanPhase['end']);
            $data['winner'] = $europeanPhase['winner'];

            $response[] = $data;
        }

        return $response;
    }

    public function getChampionEuropaGroupStandings($division, $data, $tournament)
    {
        $consumer = auth()->user()->consumer;
        if (! Arr::get($data, 'group')) {
            $data['group'] = $this->getGroup($division, $tournament, $consumer);
        }
        $europeanPhases = $this->repository->getChampionEuropaGroupStandings($data, $tournament);
        if ($europeanPhases == null) {
            return;
        }
        $standings = [];

        $teams = collect();
        foreach ($europeanPhases as $key => $europeanPhase) {
            $teams->push($europeanPhase->home);
        }

        $homePoints = $this->repository->getTeamsTotalHomePoints($teams->unique(), $data['group']);
        $awayPoints = $this->repository->getTeamsTotalAwayPoints($teams->unique(), $data['group']);

        $teams = $this->repository->getTeams($teams);
        foreach ($europeanPhases as $key => $europeanPhase) {
            if (! array_key_exists($europeanPhase->home, $standings)) {
                $standings[$europeanPhase->home]['points'] = 0;
                $standings[$europeanPhase->home]['played'] = 0;
                $standings[$europeanPhase->home]['win'] = 0;
                $standings[$europeanPhase->home]['draw'] = 0;
                $standings[$europeanPhase->home]['team_name'] = isset($teams[$europeanPhase->home]) ? $teams[$europeanPhase->home]['name'] : '';

                $id = $europeanPhase->home;
                $manager = Arr::get($teams, "$id.consumer.user");
                $standings[$europeanPhase->home]['manager_name'] = $manager['first_name'].' '.$manager['last_name'];
            }
            if (! array_key_exists($europeanPhase->away, $standings)) {
                $standings[$europeanPhase->away]['points'] = 0;
                $standings[$europeanPhase->away]['played'] = 0;
                $standings[$europeanPhase->away]['win'] = 0;
                $standings[$europeanPhase->away]['draw'] = 0;
                $standings[$europeanPhase->away]['team_name'] = isset($teams[$europeanPhase->away]) ? $teams[$europeanPhase->away]['name'] : '';
                $id = $europeanPhase->away;
                $manager = Arr::get($teams, "$id.consumer.user");
                $standings[$europeanPhase->away]['manager_name'] = $manager['first_name'].' '.$manager['last_name'];
            }
            if (isset($teams[$europeanPhase->home]) && isset($teams[$europeanPhase->away])) {
                if ($europeanPhase->home_points == 0 && $europeanPhase->away_points == 0) {
                    $standings[$europeanPhase->home]['draw'] = $standings[$europeanPhase->home]['draw'] + 0;

                    $standings[$europeanPhase->home]['points'] = $standings[$europeanPhase->home]['points'] + 0;

                    $standings[$europeanPhase->away]['draw'] = $standings[$europeanPhase->away]['draw'] + 0;

                    $standings[$europeanPhase->away]['points'] = $standings[$europeanPhase->away]['points'] + 0;

                    $standings[$europeanPhase->home]['played'] = $standings[$europeanPhase->home]['played'] + 0;
                    $standings[$europeanPhase->away]['played'] = $standings[$europeanPhase->away]['played'] + 0;
                } elseif ($europeanPhase->home_points == $europeanPhase->away_points) {
                    $standings[$europeanPhase->home]['played'] = $standings[$europeanPhase->home]['played'] + 1;
                    $standings[$europeanPhase->away]['played'] = $standings[$europeanPhase->away]['played'] + 1;

                    $standings[$europeanPhase->home]['draw'] = $standings[$europeanPhase->home]['draw'] + 1;

                    $standings[$europeanPhase->home]['points'] = $standings[$europeanPhase->home]['points'] + 1;

                    $standings[$europeanPhase->away]['draw'] = $standings[$europeanPhase->away]['draw'] + 1;

                    $standings[$europeanPhase->away]['points'] = $standings[$europeanPhase->away]['points'] + 1;
                } elseif ($europeanPhase->home_points > $europeanPhase->away_points) {
                    $standings[$europeanPhase->home]['played'] = $standings[$europeanPhase->home]['played'] + 1;
                    $standings[$europeanPhase->away]['played'] = $standings[$europeanPhase->away]['played'] + 1;

                    $standings[$europeanPhase->home]['win'] = $standings[$europeanPhase->home]['win'] + 1;

                    $standings[$europeanPhase->home]['points'] = $standings[$europeanPhase->home]['points'] + 3;
                } else {
                    $standings[$europeanPhase->home]['played'] = $standings[$europeanPhase->home]['played'] + 1;
                    $standings[$europeanPhase->away]['played'] = $standings[$europeanPhase->away]['played'] + 1;

                    $standings[$europeanPhase->away]['win'] = $standings[$europeanPhase->away]['win'] + 1;

                    $standings[$europeanPhase->away]['points'] = $standings[$europeanPhase->away]['points'] + 3;
                }
            }
        }

        $response = [];

        foreach ($standings as $key => $value) {
            $data['points'] = $value['points'];
            $data['played'] = $value['played'];
            $data['win'] = $value['win'];
            $data['loss'] = $value['played'] - ($value['win'] + $value['draw']);
            $data['draw'] = $value['draw'];
            $data['team_name'] = $value['team_name'];
            $data['team_id'] = $key;
            $data['manager_name'] = $value['manager_name'];

            $data['PF'] = @$homePoints[$key]->home_points + @$awayPoints[$key]->away_points;

            $data['PA'] = @$homePoints[$key]->away_points + @$awayPoints[$key]->home_points;

            //$data['PF'] = $homePoints[$key]->home_points + $awayPoints[$key]->away_points;
            //$data['PA'] = $homePoints[$key]->away_points + $awayPoints[$key]->home_points;

            $data['FA'] = $data['PF'] - $data['PA'];
            $response[] = $data;
        }
        $response = collect($response)
                        ->sortByDesc('PF')
                        ->sortByDesc('FA')
                        ->sortByDesc('points')
                        ->values();

        //echo "<pre>";print_r($response->toArray());echo "</pre>";exit;
        return $response->toArray();
    }

    public function checkFixtureGenerated()
    {
        return $this->repository->checkFixtureGenerated();
    }

    public function checkChampionEuropaGeneratedTeams($season)
    {
        $totalTeams = $this->repository->getChampionEuropaTeams($season, self::CHAMPIONS_LEAGUE_TEAM)->count();
        if ($totalTeams) {
            return true;
        }

        return false;
    }

    public function getManger($division, $type)
    {
        return $this->repository->getManger($division, $type);
    }
}
