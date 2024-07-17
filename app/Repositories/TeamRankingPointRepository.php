<?php

namespace App\Repositories;

use App\Enums\CompetitionEnum;
use App\Models\Division;
use App\Models\MonthTeamRankingPoint;
use App\Models\Season;
use App\Models\SeasonTeamRankingPoint;
use App\Models\Team;
use App\Models\WeekTeamRankingPoint;
use Illuminate\Support\Arr;

class TeamRankingPointRepository
{
    const MINIMUM_LEAGUE_SIZE = 5;
    const MAXIMUM_LEAGUE_SIZE = 16;

    public function truncateCurrentPoints()
    {
        WeekTeamRankingPoint::truncate();
        MonthTeamRankingPoint::truncate();

        return SeasonTeamRankingPoint::truncate();
    }

    public function getTotalTeams($data)
    {
        return Team::join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('team_point_defaults', 'team_point_defaults.team_id', '=', 'teams.id')
            ->join('fixtures', function ($join) use ($data) {
                $join->on('team_point_defaults.fixture_id', 'fixtures.id');
                $join->where('fixtures.date_time', '>=', $data['startDate']);
                $join->where('fixtures.date_time', '<=', $data['endDate']);
            })
            ->selectRaw('teams.id AS team_id,
                    (SELECT COUNT(id) FROM transfers WHERE team_id = teams.id AND transfer_type = "transfer")AS transfers,
                    SUM(team_point_defaults.total) AS total')
            ->where('division_teams.season_id',
                Season::getLatestSeason())
            ->whereNotNull('divisions.auction_closing_date')
            ->where('teams.is_approved', true)
            ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
            ->where('division_teams.season_id',
                Season::getLatestSeason())
            ->groupBy('teams.id')
            ->get();
    }

    public function createSeasonRankingPoints($data)
    {

        //Ranking points for SeasonTeamRankingPoint
        return SeasonTeamRankingPoint::create([
            'season_id' => Season::getLatestSeason(),
            'team_id' => $data['team_id'],
            'total' => $data['total'],
            'league_size' => $data['league_size'],
            'squad_size' => $data['squad_size'],
            'transfers' => $data['transfers'],
            'weekend_changes' => $data['weekend_changes'],
            'ranking_points' => $data['ranking_points'],
        ]);
    }

    public function createMonthRankingPoints($data)
    {

        //Ranking points for MonthTeamRankingPoint
        return MonthTeamRankingPoint::create([
            'season_id' => Season::getLatestSeason(),
            'team_id' => $data['team_id'],
            'total' => $data['total'],
            'league_size' => $data['league_size'],
            'squad_size' => $data['squad_size'],
            'transfers' => $data['transfers'],
            'weekend_changes' => $data['weekend_changes'],
            'ranking_points' => $data['ranking_points'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }

    public function createWeekRankingPoints($data)
    {

        //Ranking points for MonthTeamRankingPoint
        return WeekTeamRankingPoint::create([
            'season_id' => Season::getLatestSeason(),
            'team_id' => $data['team_id'],
            'total' => $data['total'],
            'league_size' => $data['league_size'],
            'squad_size' => $data['squad_size'],
            'transfers' => $data['transfers'],
            'weekend_changes' => $data['weekend_changes'],
            'ranking_points' => $data['ranking_points'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }

    public function getAveargePoints($data)
    {
        return $this->calculateAveragePoints($data);
    }

    private function calculateAveragePoints($data)
    {
        $averagePoints = [];
        $allLeaguePoints = $this->getPointsByLeague($data);
        if (! $allLeaguePoints->count()) {
            return 0;
        }
        for ($a = self::MINIMUM_LEAGUE_SIZE; $a <= self::MAXIMUM_LEAGUE_SIZE; $a++) {
            $leagueSizeDetail = $allLeaguePoints->where('league_size', $a);
            $total = $leagueSizeDetail->sum('total');
            $totalLeague = $leagueSizeDetail->sum('league_size');
            $averagePoints[$a] = round($total / $totalLeague);
        }

        return round(array_sum($averagePoints) / count($averagePoints));
    }

    private function getPointsByLeague($data)
    {
        return Division::join('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('team_point_defaults', 'team_point_defaults.team_id', '=', 'teams.id')
            ->join('fixtures', function ($join) use ($data) {
                $join->on('team_point_defaults.fixture_id', 'fixtures.id');
                $join->where('fixtures.date_time', '>=', $data['startDate']);
                $join->where('fixtures.date_time', '<=', $data['endDate']);
            })
            ->selectRaw('divisions.id AS division_id,
                    (SELECT
                    COUNT(division_teams.team_id)
                    FROM division_teams
                    INNER JOIN teams ON division_teams.team_id = teams.id
                    WHERE teams.is_approved = 1 AND division_teams.division_id = divisions.id
                    GROUP BY division_teams.division_id)AS league_size,
                    SUM(team_point_defaults.total)AS total')
            ->where('division_teams.season_id',
                Season::getLatestSeason())
            ->whereNotNull('divisions.auction_closing_date')
            ->where('teams.is_approved', true)
            ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
            ->where('division_teams.season_id',
                Season::getLatestSeason())
            ->groupBy('divisions.id')
            ->havingRaw('league_size >= ?', [self::MINIMUM_LEAGUE_SIZE])
            ->get();
    }

    public function getAllLeagueSize($data)
    {
        return $this->getPointsByLeague($data);
    }

    public function getAllTeamSeasonPositions($data)
    {
        $query = SeasonTeamRankingPoint::join('division_teams', 'division_teams.team_id', '=', 'season_team_ranking_points.team_id')
            ->join('divisions', 'division_teams.division_id', '=', 'divisions.id')
            ->select('season_team_ranking_points.team_id', 'season_team_ranking_points.ranking_points')
            ->orderBy('season_team_ranking_points.ranking_points', 'desc');

        if (Arr::has($data, 'package')) {
            $query->where('divisions.package_id', '=', $data['package']);
        }

        return $query->get();
    }

    public function getAllTeamMonthPositions($data)
    {
        $query = MonthTeamRankingPoint::join('division_teams', 'division_teams.team_id', '=', 'month_team_ranking_points.team_id')
            ->join('divisions', 'division_teams.division_id', '=', 'divisions.id')
            ->select('month_team_ranking_points.team_id', 'month_team_ranking_points.ranking_points')
            ->where('month_team_ranking_points.start_at', $data['startDate'])
            ->where('month_team_ranking_points.end_at', $data['endDate'])
            ->orderBy('month_team_ranking_points.ranking_points', 'desc');

        if (Arr::get($data, 'package', 0)) {
            $query->where('divisions.package_id', '=', $data['package']);
        }

        return $query->get();
    }

    public function getAllTeamWeekPositions($data)
    {
        $query = WeekTeamRankingPoint::join('division_teams', 'division_teams.team_id', '=', 'week_team_ranking_points.team_id')
            ->join('divisions', 'division_teams.division_id', '=', 'divisions.id')
            ->select('week_team_ranking_points.team_id', 'week_team_ranking_points.ranking_points')
            ->where('week_team_ranking_points.start_at', $data['startDate'])
            ->where('week_team_ranking_points.end_at', $data['endDate'])
            ->orderBy('week_team_ranking_points.ranking_points', 'desc');

        if (Arr::get($data, 'package', 0)) {
            $query->where('divisions.package_id', '=', $data['package']);
        }

        return $query->get();
    }
}
