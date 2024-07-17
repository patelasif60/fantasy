<?php

namespace App\Repositories;

use App\Models\ChampionEuropaFixture;
use App\Models\Division;
use App\Models\EuropeanPhase;
use App\Models\GameWeek;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ChampionEuropaRepository
{
    /**
     * Note change seasons to previous once data are perfect
     * This is only for testing purpose now.
     * Use Season::getPreviousSeason()
     * instead of Season::getLatestSeason().
     */
    public function getGameWeekPhases($season, $tournament, $name)
    {
        return $gameweek = EuropeanPhase::with(['GameWeek' => function ($query) use ($season) {
            $query->where('season_id', $season);
        }])
        ->join('gameweeks', 'european_phases.gameweek_id', '=', 'gameweeks.id')
        ->where([['tournament', '=', $tournament], ['name', 'like', '%'.escape_like($name).'%'], ['gameweeks.season_id', '=', $season]])
        ->select('european_phases.id', 'european_phases.gameweek_id', 'european_phases.name', 'european_phases.tournament')
        ->where([['tournament', '=', $tournament], ['name', 'like', '%'.escape_like($name).'%']])
        ->get();
    }

    public function create($data)
    {
        return ChampionEuropaFixture::insert($data);
    }

    public function getPreviousGameWeek($date, $tournament)
    {
        return GameWeek::with(['europeanPhases' => function ($query) use ($tournament) {
            $query->where('tournament', $tournament);
        }])
            ->whereDate('end', $date)
            ->where('season_id', Season::getLatestSeason())
            ->orderBy('end', 'DESC')
            ->first();
    }

    //Common function like affan
    public function getTeamsScores($data)
    {
        // use to decide procup fixtures

        $startDate = Arr::get($data, 'startDate');
        $endDate = Arr::get($data, 'endDate');

        $divisionTeams = Division::leftJoin('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->leftJoin(
                DB::raw("(team_point_defaults INNER JOIN fixtures ON fixtures.id = team_point_defaults.fixture_id AND DATE(fixtures.date_time) >= '$startDate' AND DATE(fixtures.date_time) < '$endDate' AND fixtures.competition = 'Premier League')"),
                function ($join) {
                    $join->on('team_point_defaults.team_id', '=', 'division_teams.team_id');
                }
            )
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->select(
                'teams.name as teamName',
                'teams.id as teamId',
                DB::raw('SUM(team_point_defaults.goal) as total_goal'),
                DB::raw('SUM(team_point_defaults.assist) as total_assist'),
                DB::raw('SUM(team_point_defaults.clean_sheet) as total_clean_sheet'),
                DB::raw('SUM(team_point_defaults.conceded) as total_conceded'),
                DB::raw('SUM(team_point_defaults.total) as total_point'),
                'users.first_name',
                'users.last_name'
            )
            ->where('teams.is_approved', true)
            ->whereIn('teams.id', Arr::get($data, 'teams'))
            ->orderBy('total_point', 'desc')
            ->orderBy('total_goal', 'desc')
            ->orderBy('total_assist', 'desc')
            ->orderBy('teamName', 'desc')
            ->groupBy('teams.id')->get();

        return $divisionTeams->keyBy('teamId');
    }

    public function update($fixture, $data)
    {
        $fixture->fill([
            'season_id' => $fixture->season_id,
            'european_phase_id' => $fixture->european_phase_id,
            'home' => $fixture->home,
            'away' => $fixture->away,
            'home_points' => Arr::get($data, 'home_points', 0),
            'away_points' => Arr::get($data, 'away_points', 0),
            'winner' => Arr::get($data, 'winner', null),
        ]);

        $fixture->save();

        return $fixture;
    }

    public function getPreviousKnockoutsGameWeek($date, $tournament)
    {
        return GameWeek::with(['europeanPhases' => function ($query) use ($tournament) {
            $query->where([['tournament', '=', $tournament], ['name', 'like', '%'.escape_like('Knockout').'%']]);
        }])
            ->whereDate('end', $date)
            ->where('season_id', Season::getPreviousSeason())
            ->orderBy('end', 'DESC')
            ->first();
    }

    public function calculateGroupAwayPoints($season, $tournament)
    {
        return Season::join('gameweeks', 'gameweeks.season_id', '=', 'seasons.id')
            ->join('european_phases', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->selectRaw('champion_europa_fixtures.away,SUM(champion_europa_fixtures.away_points) as points,champion_europa_fixtures.group_no')
            ->where([['european_phases.tournament', '=', $tournament], ['european_phases.name', 'like', '%'.escape_like('Group').'%'], ['seasons.id', '=', $season]])
            //->whereNull('champion_europa_fixtures.winner')
            ->groupBy('champion_europa_fixtures.away', 'champion_europa_fixtures.group_no')
            ->get();
    }

    public function calculateGroupHomePoints($season, $tournament)
    {
        return Season::join('gameweeks', 'gameweeks.season_id', '=', 'seasons.id')
            ->join('european_phases', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->selectRaw('champion_europa_fixtures.home,SUM(champion_europa_fixtures.home_points) as points,champion_europa_fixtures.group_no')
            ->where([['european_phases.tournament', '=', $tournament], ['european_phases.name', 'like', '%'.escape_like('Group').'%'], ['seasons.id', '=', $season]])
            //->whereNull('champion_europa_fixtures.winner')
            ->groupBy('champion_europa_fixtures.home', 'champion_europa_fixtures.group_no')
            ->get();
    }

    public function getGroupByeTeams($season, $tournament)
    {
        return Season::join('gameweeks', 'gameweeks.season_id', '=', 'seasons.id')
            ->join('european_phases', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->selectRaw('champion_europa_fixtures.home')
            ->where([['european_phases.tournament', '=', $tournament], ['european_phases.name', 'like', '%'.escape_like('Knock').'%'], ['seasons.id', '=', $season]])
            ->where('champion_europa_fixtures.bye_type', 'group')
            ->pluck('champion_europa_fixtures.home');
    }

    public function getFirstKnockout($id, $tournament, $name)
    {
        return EuropeanPhase::with('gameWeek')
        ->where([['id', '>', $id], ['tournament', '=', $tournament], ['name', 'like', '%'.escape_like($name).'%']])
        ->orderBy('id')
        ->first();
    }

    public function getWinnerFixtures($id)
    {
        return ChampionEuropaFixture::where('european_phase_id', $id)->orderBy('european_phase_id', 'DESC')->whereNotNull('winner')->get()->pluck('winner');
    }

    public function getTeams($teams = [])
    {
        return Team::with('consumer.user')->whereIn('id', $teams)->get()->keyBy('id');
    }

    public function getChampionEuropaPhases($division, $consumer, $tournament)
    {
        return EuropeanPhase::join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->join('teams', function ($join) {
                $join->on('champion_europa_fixtures.home', 'teams.id');
                $join->orOn('champion_europa_fixtures.away', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('gameweeks', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('divisions.id', '=', $division->id)
            ->where(function ($query) use ($consumer,$division) {
                $query->whereIn('teams.manager_id', $consumer)
                      ->orWhere('divisions.chairman_id', '=', $division->chairman_id);
            })
            ->where('champion_europa_fixtures.tournament_type', '=', $tournament)
            ->select('european_phases.id', 'european_phases.name', 'champion_europa_fixtures.group_no', 'gameweeks.start', 'gameweeks.end')
            ->groupBy('european_phases.id', 'european_phases.name', 'champion_europa_fixtures.group_no')
            ->get();
    }

    public function getChampionEuropaTeamPhases($division, $consumer, $tournament, $europaType)
    {
        $query = EuropeanPhase::join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->join('teams', function ($join) {
                $join->on('champion_europa_fixtures.home', 'teams.id');
                $join->orOn('champion_europa_fixtures.away', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('gameweeks', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('divisions.id', '=', $division->id)
            ->where(function ($query) use ($consumer,$division) {
                $query->whereIn('teams.manager_id', $consumer)
                      ->orWhere('divisions.chairman_id', '=', $division->chairman_id);
            })
            ->where('champion_europa_fixtures.tournament_type', '=', $tournament);
        if ($europaType == 1) {
            $query = $query->where(function ($q) use ($division) {
                $q->where('champion_europa_fixtures.home', '=', $division->europa_league_team_1)
                                  ->orWhere('champion_europa_fixtures.away', '=', $division->europa_league_team_1);
            });
        }
        if ($europaType == 2) {
            $query = $query->where(function ($q) use ($division) {
                $q->where('champion_europa_fixtures.home', '=', $division->europa_league_team_2)
                                  ->orWhere('champion_europa_fixtures.away', '=', $division->europa_league_team_2);
            });
        }

        return $query = $query->select('european_phases.id', 'european_phases.name', 'champion_europa_fixtures.group_no', 'gameweeks.start', 'gameweeks.end')
                ->groupBy('european_phases.id', 'european_phases.name', 'champion_europa_fixtures.group_no')->get();
    }

    public function getChampionEuropaPhaseFixtures($data, $divisions, $tournament)
    {
        $query = EuropeanPhase::join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->join('teams', function ($join) {
                $join->on('champion_europa_fixtures.home', 'teams.id');
                $join->orOn('champion_europa_fixtures.away', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('gameweeks', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('champion_europa_fixtures.european_phase_id', '=', $data['phase'])
            ->where('champion_europa_fixtures.tournament_type', '=', $tournament)

            ->whereNotNull('champion_europa_fixtures.away')
            ->select('champion_europa_fixtures.id as champion_europa_fixture_id', 'champion_europa_fixtures.home', 'champion_europa_fixtures.away', 'champion_europa_fixtures.home_points', 'champion_europa_fixtures.away_points', 'champion_europa_fixtures.winner', 'divisions.id as division_id', 'teams.id as team_id', 'teams.name as team_name', 'european_phases.id as european_phase_id', 'european_phases.name as european_phase_name', 'users.id as user_id', 'consumers.id as manager_id', 'gameweeks.start', 'gameweeks.end','champion_europa_fixtures.winner');

        if (Arr::get($data, 'group')) {
            $query->where('champion_europa_fixtures.group_no', '=', $data['group']);
        } else {
            if (Arr::get($data, 'team', 0)) {
                $query->where('teams.id', '=', $data['team']);
            }
            //Condition only for KO
            $query->where('divisions.id', '=', $divisions->id);
            //$query->where('consumers.id', '=', $data['consumer']);
            $query->where(function ($query) use ($data,$divisions) {
                $query->whereIn('teams.manager_id', $data['consumer'])
                      ->orWhere('divisions.chairman_id', '=', $divisions->chairman_id);
            });
        }

        return $query->get()->unique('champion_europa_fixture_id');
    }

    public function getChampionEuropaGroupStandings($data, $tournament)
    {
        return EuropeanPhase::join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->join('teams', function ($join) {
                $join->on('champion_europa_fixtures.home', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('champion_europa_fixtures.season_id', '=', Season::getLatestSeason())
            ->where('champion_europa_fixtures.group_no', '=', $data['group'])
            ->where('champion_europa_fixtures.tournament_type', '=', $tournament)
            ->whereNotNull('champion_europa_fixtures.away')
            ->select('champion_europa_fixtures.id as champion_europa_fixture_id', 'champion_europa_fixtures.home', 'champion_europa_fixtures.away', 'champion_europa_fixtures.home_points', 'champion_europa_fixtures.away_points', 'champion_europa_fixtures.winner', 'divisions.id as division_id', 'teams.id as team_id', 'teams.name as team_name', 'european_phases.id as european_phase_id', 'european_phases.name as european_phase_name', 'users.id as user_id', 'consumers.id as manager_id')
            ->get();
    }

    public function getChampionEuropaTeams($season, $column)
    {
        return Division::with(['divisionTeams' => function ($query) use ($season) {
            $query->where('season_id', $season);
        }])
        ->join('division_teams', 'division_teams.division_id', '=', 'divisions.id')
        ->where('division_teams.season_id', $season)
        ->whereNotNull('divisions.'.$column)
        ->groupBy('divisions.'.$column)
        ->pluck('divisions.'.$column);
    }

    public function getTeamsTotalHomePoints($teams, $group)
    {
        return ChampionEuropaFixture::select('home', DB::raw('SUM(home_points) as home_points'), DB::raw('SUM(away_points) as away_points'))
        ->whereIn('home', $teams)
        ->where('group_no', $group)
        ->groupBy('home')
        ->get()->keyBy('home');
    }

    public function getTeamsTotalAwayPoints($teams, $group)
    {
        return ChampionEuropaFixture::select('away', DB::raw('SUM(away_points) as away_points'), DB::raw('SUM(home_points) as home_points'))
        ->whereIn('away', $teams)
        ->where('group_no', $group)
        ->groupBy('away')
        ->get()->keyBy('away');
    }

    public function checkFixtureGenerated()
    {
        return ChampionEuropaFixture::select('id')
                ->where('season_id', Season::getLatestSeason())
                ->count();
    }

    public function maxgroupID($season)
    {
        return ChampionEuropaFixture::select(DB::raw('MAX(group_no) as max_group_no'))
        ->where('season_id', $season)->get()->first();
    }

    public function getManger($division, $type)
    {
        $query = team::select('manager_id');
        if ($type == 'champion') {
            $query->where('teams.id', '=', $division->champions_league_team);
        } else {
            $query->where(function ($query) use ($division) {
                $query->where('teams.id', '=', $division->europa_league_team_1)
                      ->orWhere('teams.id', '=', $division->europa_league_team_2);
            });
        }

        return $query->get()->pluck('manager_id');
    }
}
