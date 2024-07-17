<?php

namespace App\Repositories;

use App\Enums\CompetitionEnum;
use App\Models\Division;
use App\Models\GameWeek;
use App\Models\ProcupFixture;
use App\Models\ProcupPhase;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProcupFixtureRepository
{
    public function getFirstGameWeekByGroupSize($date, $size = null)
    {
        $gameWeek = GameWeek::join('procup_phases', 'gameweeks.id', '=', 'procup_phases.gameweek_id')
        // ->where('gameweeks.start' ,'>=', $date)
        ->where('procup_phases.size', '=', $size)
        ->where('gameweeks.season_id', Season::getLatestSeason())
        ->orderBy('gameweeks.start', 'ASC')
        ->first();

        if ($gameWeek) {
            $gameWeek = GameWeek::find($gameWeek->gameweek_id);
        }

        return $gameWeek;
    }

    public function getLastestEndGameWeek($date)
    {
        return GameWeek::where('end', '<', $date)
            ->where('season_id', Season::getLatestSeason())
            ->orderBy('end', 'DESC')
            ->first();
    }

    public function getNextGameWeek($date, $size = null)
    {
        $gameWeek = GameWeek::join('procup_phases', 'gameweeks.id', '=', 'procup_phases.gameweek_id')
        ->where('gameweeks.start', '>=', $date)
        ->where('procup_phases.size', '=', $size)
        ->where('gameweeks.season_id', Season::getLatestSeason())
        ->orderBy('gameweeks.start', 'ASC')
        ->first();

        if ($gameWeek) {
            $gameWeek = GameWeek::find($gameWeek->gameweek_id);
        }

        return $gameWeek;
    }

    public function getUpCommingGameWeek($date, $size = null)
    {
        $gameWeek = GameWeek::join('procup_phases', 'gameweeks.id', '=', 'procup_phases.gameweek_id')
        ->where('gameweeks.start', '<=', $date)
        ->where('gameweeks.end', '>', $date)
        ->where('procup_phases.size', '=', $size)
        ->where('gameweeks.season_id', Season::getLatestSeason())
        // ->orderBy('gameweeks.start','DESC')
        ->first();

        if (empty($gameWeek)) {
            $gameWeek = GameWeek::join('procup_phases', 'gameweeks.id', '=', 'procup_phases.gameweek_id')
                ->where('gameweeks.start', '>=', $date)
                ->where('procup_phases.size', '=', $size)
                ->where('gameweeks.season_id', Season::getLatestSeason())
                ->orderBy('gameweeks.start', 'ASC')
                ->first();
        }

        if ($gameWeek) {
            $gameWeek = GameWeek::find($gameWeek->gameweek_id);
        }

        return $gameWeek;
    }

    public function getRunningGameWeek($date, $size = null)
    {
        $gameWeek = GameWeek::join('procup_phases', 'gameweeks.id', '=', 'procup_phases.gameweek_id')
        ->where('gameweeks.end', '<', $date)
        ->where('procup_phases.size', '=', $size)
        ->where('gameweeks.season_id', Season::getLatestSeason())
        ->orderBy('gameweeks.end', 'DESC')
        ->first();

        if ($gameWeek) {
            $gameWeek = GameWeek::find($gameWeek->gameweek_id);
        }

        return $gameWeek;
    }

    public function getTeamsScores($data)
    {
        // use to decide procup fixtures

        $startDate = Arr::get($data, 'startDate');
        $endDate = Arr::get($data, 'endDate');
        $competition = CompetitionEnum::PREMIER_LEAGUE;
        $divisionTeams = Division::leftJoin('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->leftJoin(
                DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id AND DATE(fixtures.date_time) >= '$startDate' AND DATE(fixtures.date_time) <= '$endDate' AND fixtures.competition = '$competition')"),
                function ($join) {
                    $join->on('team_points.team_id', '=', 'division_teams.team_id');
                }
            )
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->select(
                'teams.name as teamName',
                'teams.id as teamId',
                DB::raw('SUM(team_points.goal) as total_goal'),
                DB::raw('SUM(team_points.assist) as total_assist'),
                DB::raw('SUM(team_points.clean_sheet) as total_clean_sheet'),
                DB::raw('SUM(team_points.conceded) as total_conceded'),
                DB::raw('SUM(team_points.total) as total_point'),
                'users.first_name',
                'users.last_name'
            )
            ->where('teams.is_approved', true)
            ->whereIn('teams.id', Arr::get($data, 'teams'))
            ->orderBy('total_point', 'desc')->groupBy('teams.id')->get();

        return $divisionTeams->keyBy('teamId');
    }

    public function getTeams($teams = [])
    {
        return Team::with('consumer.user')
                ->whereIn('id', $teams)
                ->where('is_approved', true)
                ->get();
    }

    public function getDivisionGroups()
    {
        return Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->where('teams.is_approved', 1)
            ->select('divisions.*')
            ->withCount(['divisionTeams' => function ($query) {
                $query->where('season_id', Season::getLatestSeason());
            }])->get();
    }

    public function getWinnerProcupFixtures($key, $data)
    {
        return ProcupFixture::where('size', $key)->where('procup_phase_id', Arr::get($data, '0'))->orderBy('procup_phase_id', 'DESC')->whereNotNull('winner')->get()->pluck('winner');
    }

    public function create($data)
    {
        return ProcupFixture::create([
            'season_id' => Season::getLatestSeason(),
            'procup_phase_id' => $data['procup_phase_id'],
            'size' => $data['size'],
            'home' => $data['home'],
            'away' => Arr::get($data, 'away', null),
            'home_points' => Arr::get($data, 'home_points', null),
            'away_points' => Arr::get($data, 'away_points', null),
            'winner' => Arr::get($data, 'winner', null),
        ]);
    }

    public function createMultiple($data)
    {
        return ProcupFixture::insert($data);
    }

    public function update($procupFixture, $data)
    {
        $procupFixture->fill([
            'season_id' => $procupFixture->season_id,
            'procup_phase_id' => $procupFixture->procup_phase_id,
            'size' => $procupFixture->size,
            'home' => $procupFixture->home,
            'away' => $procupFixture->away,
            'home_points' => Arr::get($data, 'home_points', null),
            'away_points' => Arr::get($data, 'away_points', null),
            'winner' => Arr::get($data, 'winner', null),
        ]);

        return $procupFixture->save();
    }

    public function getPhases($division, $consumer)
    {
        return ProcupPhase::join('procup_fixtures', 'procup_fixtures.procup_phase_id', '=', 'procup_phases.id')
            ->join('teams', function ($join) {
                $join->on('procup_fixtures.home', 'teams.id');
                $join->orOn('procup_fixtures.away', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('divisions.id', '=', $division->id)
            ->where('consumers.id', '=', $consumer)
            ->select('procup_phases.id', 'procup_phases.name')
            ->groupBy('procup_phases.id')
            ->pluck('name', 'id');
    }

    public function getPhaseFixtures($phase, $division, $consumer)
    {
        return ProcupPhase::join('procup_fixtures', 'procup_fixtures.procup_phase_id', '=', 'procup_phases.id')
                    ->join('teams', function ($join) {
                        $join->on('procup_fixtures.home', 'teams.id');
                        $join->orOn('procup_fixtures.away', 'teams.id');
                    })
                    ->join('gameweeks', 'procup_phases.gameweek_id', '=', 'gameweeks.id')
                    ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
                    ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->where('divisions.id', '=', $division->id)
                    ->where('consumers.id', '=', $consumer)
                    ->where('procup_fixtures.procup_phase_id', $phase)
                    ->select('procup_fixtures.home', 'procup_fixtures.away', 'procup_fixtures.home_points', 'procup_fixtures.away_points', 'procup_fixtures.winner', 'divisions.id as division_id', 'teams.id as team_id', 'teams.name as team_name', 'procup_fixtures.id as procup_fixture_id', 'procup_phases.id as procup_phase_id', 'procup_phases.name as procup_phase_name', 'users.id as user_id', 'consumers.id as manager_id', 'gameweeks.start', 'gameweeks.end')
                    ->get();
    }
}
