<?php

namespace App\DataTables;

use App\Models\DivisionTeam;
use App\Models\Team;
use App\Models\TeamPoint;
use Yajra\DataTables\Services\DataTable;

class TeamPointsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('week', function ($data) {
            return $data->number;
        })->filter(function ($query) {

            // Check for the presence of uuid in request.
            $query->when(request()->has('uuid'), function ($query) {
                $team = DivisionTeam::where('season_id', request('season'))->whereIn('team_id', Team::where('uuid', request('uuid'))->pluck('id'))->pluck('team_id');
                if ($team->isEmpty()) {
                    $query->where('team_id', request('team'));
                } else {
                    $query->whereIn('team_id', $team);
                }
            });

            // Check for the uuid if not exist
            $query->unless(request()->has('uuid'), function ($query) {
                return $query->where('team_id', request('team'));
            });
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TeamPoint $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TeamPoint $model)
    {
        return TeamPoint::selectRaw('gameweeks.number, SUM(`goal`) goals,SUM(`assist`) assists, SUM(`clean_sheet`) clean_sheets, SUM(`conceded`) goals_against, SUM(`appearance`) def_app, SUM(`total`) total, team_id')
            ->join('fixtures', 'team_points.fixture_id', '=', 'fixtures.id')
            ->join('seasons', 'fixtures.season_id', '=', 'seasons.id')
            ->join('gameweeks', 'gameweeks.season_id', '=', 'seasons.id')
            ->whereRaw('fixtures.date_time BETWEEN gameweeks.start AND gameweeks.end')
            ->where('fixtures.season_id', request('season'))
            ->groupBy('team_id')
            ->groupBy('gameweeks.number');
    }
}
