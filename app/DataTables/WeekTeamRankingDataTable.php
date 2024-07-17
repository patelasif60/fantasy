<?php

namespace App\DataTables;

use App\Models\Season;
use App\Models\WeekTeamRankingPoint;
use App\Services\TeamRankingPointService;
use Yajra\DataTables\Services\DataTable;

class WeekTeamRankingDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $params = [];
        $teamPositions = [];
        if (request()->has('startDt') && request()->has('endDt')) {
            $params['startDate'] = request()->get('startDt');
            $params['endDate'] = request()->get('endDt');
            $params['package'] = request()->get('package');

            $teamRankingPointService = app(TeamRankingPointService::class);
            $allTeamPositions = $teamRankingPointService
                            ->getAllTeamWeekPositions($params)
                            ->sortByDesc('ranking_points')
                            ->pluck('ranking_points', 'team_id');

            $teamPositions = get_team_position_from_rank_points($allTeamPositions);

            return datatables($query)
            ->addColumn('position', function ($data) use ($teamPositions) {
                return $teamPositions->get($data->id, 0);
            });
        }

        return datatables($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Season $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WeekTeamRankingPoint $model)
    {
        $teams = $model::join('teams', 'teams.id', '=', 'week_team_ranking_points.team_id')
                    ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
                    ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->where('week_team_ranking_points.season_id', Season::getLatestSeason());

        if (request()->has('startDt') && request()->has('endDt')) {
            $teams = $teams->where('week_team_ranking_points.start_at', '>=', request()->get('startDt'))
                                        ->where('week_team_ranking_points.end_at', '<=', request()->get('endDt'));
        }

        if (request()->has('package')) {
            $teams = $teams->where('divisions.package_id', request()->get('package'));
        }

        $teams = $teams->selectRaw('teams.id, teams.name, users.`first_name`, users.last_name, week_team_ranking_points.total, week_team_ranking_points.league_size, week_team_ranking_points.squad_size, week_team_ranking_points.transfers, week_team_ranking_points.weekend_changes,week_team_ranking_points.ranking_points')
                ->orderBy('week_team_ranking_points.ranking_points', 'desc');

        return $teams;
    }
}
