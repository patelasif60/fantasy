<?php

namespace App\DataTables;

use App\Models\Season;
use App\Models\SeasonTeamRankingPoint;
use App\Services\TeamRankingPointService;
use Yajra\DataTables\Services\DataTable;

class SeasonTeamRankingDataTable extends DataTable
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
        if (request()->has('package')) {
            $params['package'] = request()->get('package');
        }
        $teamRankingPointService = app(TeamRankingPointService::class);
        $allTeamPositions = $teamRankingPointService->getAllTeamSeasonPositions($params)->sortByDesc('ranking_points')->pluck('ranking_points', 'team_id');
        $teamPositions = get_team_position_from_rank_points($allTeamPositions);

        return datatables($query)
        ->addColumn('position', function ($data) use ($teamPositions) {
            return $teamPositions->get($data->id, 0);
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Season $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SeasonTeamRankingPoint $model)
    {
        $teams = $model::join('teams', 'teams.id', '=', 'season_team_ranking_points.team_id')
                    ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
                    ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->where('season_team_ranking_points.season_id', Season::getLatestSeason());

        if (request()->has('package')) {
            $teams = $teams->where('divisions.package_id', request()->get('package'));
        }

        $teams = $teams->selectRaw('teams.id, teams.name, users.`first_name`, users.last_name, season_team_ranking_points.total, season_team_ranking_points.league_size, season_team_ranking_points.squad_size, season_team_ranking_points.transfers, season_team_ranking_points.weekend_changes,season_team_ranking_points.ranking_points')
                ->orderBy('season_team_ranking_points.ranking_points', 'desc');

        return $teams;
    }
}
