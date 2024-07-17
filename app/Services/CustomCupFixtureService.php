<?php

namespace App\Services;

use App\Enums\CustomCupStatusEnum;
use App\Models\Season;
use App\Models\Team;
use App\Repositories\CustomCupFixtureRepository;
use App\Repositories\DivisionRepository;
use App\Repositories\ProcupFixtureRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class CustomCupFixtureService
{
    /**
     * The procup phase repository instance.
     *
     * @var repository
     */
    protected $repository;

    protected $divisionRepository;

    protected $proCupFixtureRepository;

    public function __construct(CustomCupFixtureRepository $repository, DivisionRepository $divisionRepository, ProcupFixtureRepository $proCupFixtureRepository)
    {
        $this->repository = $repository;
        $this->divisionRepository = $divisionRepository;
        $this->proCupFixtureRepository = $proCupFixtureRepository;
    }

    public function manageFixtures($date)
    {
        $customCups = $this->getStartGameweekRecords($date)->sortByDesc('id');
        $this->manageRoundsAndTeams($customCups);
    }

    protected function manageRoundsAndTeams($customCups)
    {
        foreach ($customCups as $key => $customCup) {
            $customCupRound = $customCup->rounds->sortBy('round', 1)->first();
            $byeTeamCount = bye_teams_count($customCup->teams->count());

            $round = $customCupRound->gameweeks->sortByDesc('gameweek_id')->first();
            if ($customCup->is_bye_random && $byeTeamCount) {
                $byes = $customCup->teams->where('is_bye', true)->pluck('team_id');
                $knockouts = $customCup->teams->where('is_bye', false)->pluck('team_id')->shuffle()->chunk(2);
            } else {
                $teams = $customCup->teams->pluck('team_id');
                $byes = $customCup->teams->shuffle()->take($byeTeamCount)->pluck('team_id');
                $knockouts = $teams->diff($byes)->shuffle()->chunk(2);
            }

            $this->generateFixtures($round, $byes, $knockouts);
            $this->update($customCup, ['status' => CustomCupStatusEnum::ACTIVE]);
        }
    }

    protected function generateFixtures($round, $byes, $knockouts)
    {
        $this->createByes($round, $byes);
        $this->createKnockouts($round, $knockouts);
    }

    protected function createByes($round, $byes)
    {
        $fixtures = [];
        foreach ($byes as $bye) {
            $fixtures[] = [
                'custom_cup_round_id' => $round->custom_cup_round_id,
                'gameweek_id' => $round->gameweek_id,
                'home' => $bye,
                'winner' => $bye,
                'season_id' => Season::getLatestSeason(),
                'created_at' => now()->format(config('fantasy.db.datetime.format')),
                'updated_at' =>now()->format(config('fantasy.db.datetime.format')),
            ];
        }
        if (! empty($fixtures)) {
            $this->repository->createMultiple($fixtures);
        }
    }

    protected function createKnockouts($round, $knockouts)
    {
        $fixtures = [];
        foreach ($knockouts as $knockout) {
            $knockout = $knockout->values();

            if (Arr::get($knockout, '1')) {
                $fixtures[] = [
                    'custom_cup_round_id' => $round->custom_cup_round_id,
                    'gameweek_id' => $round->gameweek_id,
                    'home' => Arr::get($knockout, '0'),
                    'away' => Arr::get($knockout, '1'),
                    'season_id' => Season::getLatestSeason(),
                    'created_at' =>now()->format(config('fantasy.db.datetime.format')),
                    'updated_at' =>now()->format(config('fantasy.db.datetime.format')),
                ];
            }
        }

        if (! empty($fixtures)) {
            $this->repository->createMultiple($fixtures);
        }
    }

    public function updateFixtures($date)
    {
        $customCupRounds = $this->getCustomCup($date);
        $this->updateRoundFixtures($customCupRounds);
    }

    protected function updateRoundFixtures($customCupRounds)
    {
        foreach ($customCupRounds as $key => $customCupRound) {
            $customCupTeams = $customCupRound->customCup->teams->keyBy('team_id');

            if ($customCupTeams->count()) {
                foreach ($customCupRound->fixtures->where('away', '!=', '') as $fixture) {
                    $home = $fixture->home;
                    $away = $fixture->away;

                    foreach ($customCupRound->gameweeks as $roundGameweek) {
                        $gameweek = $roundGameweek->gameweek;

                        $data['startDate'] = $gameweek['start'];
                        $data['endDate'] = $gameweek['end'];
                        $data['teams'] = [$home, $away];
                        $teamScores[] = $this->getTeamsScores($data)->keyBy('teamId');
                    }

                    $this->calculateUpdateGameweekTeamPoints($fixture, $teamScores, $customCupTeams);
                }
            }
        }
    }

    protected function calculateUpdateGameweekTeamPoints($fixture, $teamScores, $customCupTeams)
    {
        $home = $fixture->home;
        $away = $fixture->away;

        $homePoint = 0;
        $homeGoal = 0;
        $homeAssist = 0;

        $awayGoal = 0;
        $awayAssist = 0;
        $awayPoint = 0;

        foreach ($teamScores as $key => $teamScore) {
            $homePoint += Arr::get($teamScore, "$home.total_point");
            $homeGoal += Arr::get($teamScore, "$home.total_goal");
            $homeAssist += Arr::get($teamScore, "$home.total_assist");

            $awayPoint += Arr::get($teamScore, "$away.total_point");
            $awayGoal += Arr::get($teamScore, "$away.total_goal");
            $awayAssist += Arr::get($teamScore, "$away.total_assist");
        }
        $update['home_points'] = $homePoint;
        $update['away_points'] = $awayPoint;

        if ($homePoint > $awayPoint) {
            $update['winner'] = $home;
        } else {
            if ($homePoint < $awayPoint) {
                $update['winner'] = $away;
            } else { // point same
                if ($homeGoal > $awayGoal) {
                    $update['winner'] = $home;
                } else {
                    if ($homeGoal < $awayGoal) {
                        $update['winner'] = $away;
                    } else {
                        if ($homeAssist > $awayAssist) {
                            $update['winner'] = $home;
                        } else {
                            $update['winner'] = $away;
                        }
                        // point same decide by team name alpha order
                        // $homeTeam = Arr::get($customCupTeams, "$home.team.name");
                        // $awayTeam = Arr::get($customCupTeams, "$away.team.name");

                        // if (! strcasecmp($homeTeam, $awayTeam)) {
                        //     $update['winner'] = $home;
                        // } else {
                        //     $update['winner'] = $away;
                        // }
                    }
                }
            }
        }

        $this->update($fixture, $update);
    }

    public function generateNextFixturesDelete($date)
    {
        $customCupRounds = $this->getEndGameweekRecords($date);

        foreach ($customCupRounds as $key => $customCupRound) {

            $nextRoundFixtures = $customCupRound->customCup->rounds->sortBy('id')->where('id', '>', $customCupRound->id)->first();

            if($nextRoundFixtures) {
                $nextRound = $nextRoundFixtures->gameweeks->sortByDesc('gameweek_id')->first();
                if($nextRound) {
                    $this->deleteFixturesByRoundGameWeek($nextRound);
                }
            }
        }
    }

    public function generateNextFixtures($date)
    {
        $customCupRounds = $this->getEndGameweekRecords($date);

        foreach ($customCupRounds as $key => $customCupRound) {
            $winnerTeamFixtures = $this->getRoundWinnerTeams($customCupRound->id)->pluck('winner')->shuffle()->chunk(2);

            $nextRoundFixtures = $customCupRound->customCup->rounds->sortBy('id')->where('id', '>', $customCupRound->id)->first();

            if (Arr::has($nextRoundFixtures, 'fixtures') && $nextRoundFixtures->fixtures->isEmpty()) {
                $nextRound = $nextRoundFixtures->gameweeks->sortByDesc('gameweek_id')->first();

                $this->createNextRounfdFixtures($winnerTeamFixtures, $nextRound);
            }
        }
    }

    protected function createNextRounfdFixtures($winnerTeamFixtures, $nextRound)
    {
        $fixtures = [];
        foreach ($winnerTeamFixtures as $winnerTeamFixture) {
            $winnerTeams = $winnerTeamFixture->values();
            if (Arr::get($winnerTeams, '1')) {
                $fixtures[] = [
                    'custom_cup_round_id' => $nextRound->custom_cup_round_id,
                    'gameweek_id' => $nextRound->gameweek_id,
                    'home' => Arr::get($winnerTeams, '0'),
                    'away' => Arr::get($winnerTeams, '1'),
                    'season_id' => Season::getLatestSeason(),
                    'created_at' =>now()->format(config('fantasy.db.datetime.format')),
                    'updated_at' =>now()->format(config('fantasy.db.datetime.format')),
                ];
            }
        }

        if (! empty($fixtures)) {
            $this->repository->createMultiple($fixtures);
        }
    }

    public function getManagerCupRounds($division, $team)
    {
        return $this->repository->getManagerCupRounds($division, $team);
    }

    public function getCupRoundCount($teams, $round)
    {
        $rounds = get_log_value($teams);
        $totalTeams = bye_teams_count($teams) + $teams;

        $roundTeams = $totalTeams;
        for ($i = 1; $i <= $rounds; $i++) {
            $roundTeams = ($roundTeams / 2);
            if ($round == $i) {
                break;
            }
        }

        return $roundTeams;
    }

    public function getRoundFixtureFilter($division, $customCup, $round)
    {
        $customCup->load('rounds.gameweeks.gameweek');
        $fixtures = $customCup->rounds->where('round', '=', $round)->first()->fixtures;

        if ($fixtures->count()) {
            return $this->getFixtuers($fixtures, $customCup, $round);
        }

        $count = $this->getCupRoundCount($customCup->teams->count(), $round);
        $crest = asset('assets/frontend/img/crest-logo/crest.png');
        $title = $this->getGameWeekTitle($customCup, $round);

        for ($i = 0; $i < $count; $i++) {
            $data[$i]['home_team_id'] = '';
            $data[$i]['home_team_name'] = 'TBC';
            $data[$i]['home_manager'] = 'TBC';
            $data[$i]['home_points'] = '-';
            $data[$i]['home_crest'] = $crest;
            $data[$i]['away_team_id'] = '';
            $data[$i]['away_team_name'] = 'TBC';
            $data[$i]['away_points'] = '-';
            $data[$i]['away_manager'] = 'TBC';
            $data[$i]['away_crest'] = $crest;
            $data[$i]['gameweek'] = $title;
        }

        return $data;
    }

    public function getGameWeekTitle($customCup, $round)
    {
        $roundGameweek = $customCup->rounds->where('round', $round)->first()->gameweeks;
        $start = $roundGameweek->first()->gameweek->start;
        $end = $roundGameweek->last()->gameweek->end;

        return Carbon::parse($start)->format(config('fantasy.view.day_month')).' - '.Carbon::parse($end)->format(config('fantasy.view.day_month'));
    }

    public function getFixtuers($fixtures, $customCup, $round)
    {
        $homeTeams = $fixtures->pluck('home');
        $awayTeams = $fixtures->pluck('away');

        $totalTeams = $homeTeams->merge($awayTeams)->filter();
        $teams = $this->getTeams($totalTeams);
        $gmwk = $this->getGameWeekTitle($customCup, $round);

        $response = [];
        foreach ($fixtures as $fixture) {
            $team = $teams->where('id', $fixture['home'])->first();
            $data['gameweek'] = $gmwk;
            $data['home_team_id'] = $team->id;
            $data['home_team_name'] = $team->name;
            $id = $fixture['home'];
            $data['home_manager'] = $team->consumer->user->first_name.' '.$team->consumer->user->last_name;
            $data['home_points'] = $fixture['home_points'];
            $data['home_crest'] = $team ? $team->getCrestImageThumb() : '';

            if (! empty($fixture['away'])) {
                $team = $teams->where('id', $fixture['away'])->first();
                $data['away_team_id'] = $team->id;
                $data['away_team_name'] = $team->name;
                $data['away_manager'] = $team->consumer->user->first_name.' '.$team->consumer->user->last_name;
                $data['away_points'] = $fixture['away_points'];
                $data['away_crest'] = $team ? $team->getCrestImageThumb() : '';
            } else {
                $data['away_team_id'] = '';
                $data['away_team_name'] = '';
                $data['away_points'] = '-';
                $data['away_manager'] = '';
            }
            $data['winner'] = $fixture['winner'];

            $response[] = $data;
        }

        return $response;
    }

    public function getCustomCups($division, $consumer)
    {
        if ($consumer->divisions->count() ||
            $consumer->ownTeamInParentAssociatedLeague($division)) {
            // getCustomCups all for chairman or for all parent league teams maanger
            $customCups = $division->customCup->where('status', '=', CustomCupStatusEnum::ACTIVE);
        } else { // login user is manager
            $team = $consumer->ownTeamDetails($division);
            if ($team->count()) {
                $customCups = $this->getManagerCupRounds($division, $team);
            }
        }

        return $customCups;
    }

    public function getCupActiveRound($customCup)
    {
        $activeRound = 0;

        foreach ($customCup->rounds as $round) {
            $first = $round->gameweeks->first()->gameweek->start;
            $last = $round->gameweeks->last()->gameweek->end;

            if ($first->lte(now()) && $last->gte(now())) {
                return $round->round;
            }
        }

        $round = $customCup->rounds->last();
        
        if($round) {

            return $round->round;
        }

        return $activeRound;
    }

    public function getTeams($ids)
    {
        return $this->proCupFixtureRepository->getTeams($ids);
    }

    public function getStartGameweekRecords($date = null)
    {
        return $this->repository->getStartGameweekRecords($date);
    }

    public function getEndGameweekRecords($date = null)
    {
        return $this->repository->getEndGameweekRecords($date);
    }

    public function getCustomCup($date = null)
    {
        return $this->repository->getCustomCup($date);
    }

    public function getRoundGameweek($data)
    {
        return $this->repository->getRoundGameweek($data);
    }

    public function getTeamsScores($data)
    {
        return $this->divisionRepository->getTeamsScores($data);
    }

    public function update($fixture, $data)
    {
        return $this->repository->update($fixture, $data);
    }

    public function getRoundWinnerTeams($id)
    {
        return $this->repository->getRoundWinnerTeams($id);
    }

    public function deleteFixturesByRoundGameWeek($gameweek)
    {
        return $this->repository->deleteFixturesByRoundGameWeek($gameweek);
    }
}
