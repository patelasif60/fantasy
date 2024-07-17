<?php

namespace App\Repositories;

use App\Enums\HeadToHeadFixturesOutcomeEnum;
use App\Enums\HeadToHeadFixturesStatusEnum;
use App\Models\DivisionTeam;
use App\Models\HeadToHeadFixture;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class HeadToHeadFixtureRepository
{
    public function update($fixture, $data)
    {
        $fixture->fill([
            'status' => $data['status'],
            'outcome' => $data['outcome'],
            'home_team_points' => $data['home_team_points'],
            'away_team_points' => $data['away_team_points'],
            'home_team_head_to_head_points' => $data['home_team_head_to_head_points'],
            'away_team_head_to_head_points' => $data['away_team_head_to_head_points'],
            'winner_id' => $data['winner_id'],
        ]);

        $fixture->save();

        return $fixture;
    }

    public function getFixturesFromGameWeek($gameweek)
    {
        $fixtures = HeadToHeadFixture::join('league_phases', 'league_phases.id', '=', 'head_to_head_fixtures.league_phase_id')
                ->join('gameweeks', 'gameweeks.id', '=', 'league_phases.gameweek_id')
                ->where('gameweeks.id', $gameweek->id)
                ->select('head_to_head_fixtures.*')
                ->get();

        return $fixtures;
    }

    public function getDivisionHeadToHeadTeamsScores($division)
    {
        $teams = Team::join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('division_teams.division_id', $division->id)
            ->where('division_teams.season_id', Season::getLatestSeason())
            ->where('teams.is_approved', true)
            ->select('teams.*','users.first_name', 'users.last_name')
            ->get();

        $teamsArray = $teams->pluck('id')->toArray();

        $homeTeams = HeadToHeadFixture::select('home_team_id', DB::raw('SUM(head_to_head_fixtures.home_team_head_to_head_points) as points'))
                    ->whereIn('head_to_head_fixtures.home_team_id', $teamsArray)
                    //->orWhereIn('head_to_head_fixtures.away_team_id', $teamsArray)
                    ->groupBy('head_to_head_fixtures.home_team_id')
                    ->get();

        if(!$homeTeams->count()) {

        	return collect();
        }

        $awayTeams = HeadToHeadFixture::select('away_team_id', DB::raw('SUM(head_to_head_fixtures.away_team_head_to_head_points) as points'))
                    ->whereIn('away_team_id', $teamsArray)
                    //->orWhereIn('home_team_id', $teamsArray)
                    ->groupBy('head_to_head_fixtures.away_team_id')
                    ->get();

        $homePlayed = HeadToHeadFixture::select('home_team_id', DB::raw('COUNT(*) as played'))
                    ->where('status', HeadToHeadFixturesStatusEnum::PLAYED)
                    ->whereIn('home_team_id', $teamsArray)
                    ->groupBy('home_team_id')
                    ->groupBy('status')
                    ->get();

        $awayPlayed = HeadToHeadFixture::select('away_team_id', DB::raw('COUNT(*) as played'))
                    ->where('status', HeadToHeadFixturesStatusEnum::PLAYED)
                    ->whereIn('away_team_id', $teamsArray)
                    ->groupBy('away_team_id')
                    ->groupBy('status')
                    ->get();

        $winners = HeadToHeadFixture::select('winner_id', DB::raw('COUNT(*) as winner'))
                    ->whereIn('away_team_id', $teamsArray)
                    ->orWhereIn('home_team_id', $teamsArray)
                    ->whereNotNull('winner_id')
                    ->groupBy('winner_id')
                    ->get();

        $homeDraws = HeadToHeadFixture::select('home_team_id', DB::raw('COUNT(*) as draw'))
                    ->where('outcome', HeadToHeadFixturesOutcomeEnum::D)
                    ->whereIn('home_team_id', $teamsArray)
                    ->groupBy('home_team_id')
                    ->groupBy('outcome')
                    ->get();

        $awayDraws = HeadToHeadFixture::select('away_team_id', DB::raw('COUNT(*) as draw'))
                    ->where('outcome', HeadToHeadFixturesOutcomeEnum::D)
                    ->whereIn('away_team_id', $teamsArray)
                    ->groupBy('away_team_id')
                    ->groupBy('outcome')
                    ->get();

        $homeLoses = HeadToHeadFixture::select('home_team_id', DB::raw('COUNT(*) as loses'))
                    ->where('outcome', HeadToHeadFixturesOutcomeEnum::A)
                    ->whereIn('home_team_id', $teamsArray)
                    ->groupBy('home_team_id')
                    ->groupBy('outcome')
                    ->get();

        $awayLoses = HeadToHeadFixture::select('away_team_id', DB::raw('COUNT(*) as loses'))
                    ->where('outcome', HeadToHeadFixturesOutcomeEnum::H)
                    ->whereIn('away_team_id', $teamsArray)
                    ->groupBy('away_team_id')
                    ->groupBy('outcome')
                    ->get();

        $teamsArrayToString = implode(',', $teamsArray);

        $points = collect(DB::select(DB::raw('SELECT t.id AS teamId, SUM(F) AS points_for,SUM(A) AS points_against FROM( SELECT home_team_id AS teamId, home_team_points F, away_team_points A FROM head_to_head_fixtures WHERE home_team_id IN ('.$teamsArrayToString.') UNION ALL SELECT away_team_id AS teamId, away_team_points, home_team_points FROM head_to_head_fixtures WHERE away_team_id IN ('.$teamsArrayToString.')) AS tot JOIN teams t ON tot.teamId = t.id GROUP BY tot.teamId')));

        $data = [];
        foreach ($teams as $team) {

            $away = $awayTeams->where('away_team_id', $team->id)->first();
            $home = $homeTeams->where('home_team_id', $team->id)->first();

            $homePlay = $homePlayed->where('home_team_id', $team->id)->first();
            $awayPlay = $awayPlayed->where('away_team_id', $team->id)->first();

            $winner = $winners->where('winner_id', $team->id)->first();

            $homeDraw = $homeDraws->where('home_team_id', $team->id)->first();
            $awayDraw = $awayDraws->where('away_team_id', $team->id)->first();

            $homeLose = $homeLoses->where('home_team_id', $team->id)->first();
            $awayLose = $awayLoses->where('away_team_id', $team->id)->first();

            $pointFor = $points->where('teamId', $team->id)->sum('points_for');
            $pointAgainst = $points->where('teamId', $team->id)->sum('points_against');

            $pointDiff = ($pointFor - $pointAgainst);

            $data[] = [
                'teamId' => $team->id,
                'teamName' => $team->name,
                'team_points' => ( ($home ? $home->points : 0) + ($away ? $away->points : 0) ),
                'plays' => ($homePlay ? $homePlay->played : 0) + ($awayPlay ? $awayPlay->played : 0),
                'wins' => $winner ? $winner->winner : 0,
                'draws' => ($homeDraw ? $homeDraw->draw : 0) + ($awayDraw ? $awayDraw->draw : 0),
                'loses' => ($homeLose ? $homeLose->loses : 0) + ($awayLose ? $awayLose->loses : 0),
                'points_for' => $pointFor,
                'points_against' => $pointAgainst,
                'points_diff' => $pointDiff,
                'first_name' => $team->first_name,
                'last_name' => $team->last_name,
                'league_position' => 0,
                'crest' => $team ? $team->getCrestImageThumb() : '',
            ];
        }

        $divisionTeamsData = collect($data)
                ->sortByDesc('points_for')
                ->sortByDesc('points_diff')
                ->sortByDesc('team_points')
                ->values()
                ->all();

        $position = 0;
        $temp = 0;
        foreach ($divisionTeamsData as $key => $value) {
            $teamPoints = $value['team_points'];
            $pointsDiff = $value['points_diff'];
            $pointsFor = $value['points_for'];

            if ($key > 0) {
                if ($teamPoints == $divisionTeamsData[$key - 1]['team_points'] && $pointsDiff == $divisionTeamsData[$key - 1]['points_diff']) {
                    $temp++;
                } else {
                    $position++;
                    $position = $position + $temp;
                    $temp = 0;
                }
            } else {
                $position++;
                $position = $position + $temp;
                $temp = 0;
            }
            $divisionTeamsData[$key]['league_position'] = $position;
        }

        return $divisionTeamsData;
    }

    public function getDivisionHeadToHeadTeamsScoresFromGameWeek($division, $gameweek)
    {
        $teams = HeadToHeadFixture::join('league_phases', 'league_phases.id', '=', 'head_to_head_fixtures.league_phase_id')
                ->join('gameweeks', 'gameweeks.id', '=', 'league_phases.gameweek_id')
                ->join('teams as home_teams', 'home_teams.id', '=', 'head_to_head_fixtures.home_team_id')
                ->join('teams as away_teams', 'away_teams.id', '=', 'head_to_head_fixtures.away_team_id')
                ->join('division_teams as home_division_teams', 'home_division_teams.team_id', '=', 'head_to_head_fixtures.home_team_id')
                ->join('division_teams as away_division_teams', 'away_division_teams.team_id', '=', 'head_to_head_fixtures.away_team_id')
                ->join('consumers as homeConsumers', 'homeConsumers.id', '=', 'home_teams.manager_id')
                ->join('users as homeUsers', 'homeUsers.id', '=', 'homeConsumers.user_id')
                ->join('consumers as awayConsumers', 'awayConsumers.id', '=', 'away_teams.manager_id')
                ->join('users as awayUsers', 'awayUsers.id', '=', 'awayConsumers.user_id')
                ->where('home_division_teams.division_id', $division->id)
                ->where('away_division_teams.division_id', $division->id)
                ->where('head_to_head_fixtures.season_id', Season::getLatestSeason())
                ->where('gameweeks.id', $gameweek->id)
                ->select(
                    'home_teams.name AS homeTeam',
                    'away_teams.name AS awayTeam',
                    'home_teams.id AS homeTeamId',
                    'away_teams.id AS awayTeamId',
                    'head_to_head_fixtures.home_team_points as homePoints',
                    'head_to_head_fixtures.away_team_points as awayPoints',
                    'homeUsers.first_name as homeFirstName',
                    'homeUsers.last_name as homeLastName',
                    'awayUsers.first_name as awayFirstName',
                    'awayUsers.last_name as awayLastName',
                    'gameweeks.start',
                    'gameweeks.end'
                )
                ->get();

        return $teams;
    }
}
