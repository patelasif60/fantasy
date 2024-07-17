<?php

namespace App\DataTables;

use App\Models\TeamPlayerPoint;
use Yajra\DataTables\Services\DataTable;

class TeamPlayerPointsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('name', function ($data) {
            return $data->player->full_name;
        })
        ->addColumn('club', function ($data) {
            return $data->player->playerContract->club->name;
        })
        ->addColumn('position', function ($data) {
            return $data->player->playerContract->position;
        })
        ->addColumn('app', function ($data) {
            return $data->appearance;
        })
        ->addColumn('goals', function ($data) {
            return $data->goals;
        })
        ->addColumn('assists', function ($data) {
            return $data->assists;
        })
        ->addColumn('clean_sheets', function ($data) {
            return $data->clean_sheets;
        })
        ->addColumn('conceded', function ($data) {
            return $data->conceded;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TeamPlayerPoint $model)
    {
        return TeamPlayerPoint::selectRaw('gameweeks.number as number, SUM(`team_player_points`.`goal`) goals, SUM(`team_player_points`.`assist`) assists, SUM(`team_player_points`.`clean_sheet`) clean_sheets, SUM(`team_player_points`.`conceded`) conceded, SUM(`team_player_points`.`appearance`) appearance, SUM(`team_player_points`.`total`) total, `team_player_points`.player_id')
             ->join('team_points', 'team_player_points.team_point_id', '=', 'team_points.id')

            ->join('fixtures', 'team_points.fixture_id', '=', 'fixtures.id')
            ->join('seasons', 'fixtures.season_id', '=', 'seasons.id')
            ->join('gameweeks', 'gameweeks.season_id', '=', 'seasons.id')
            ->whereRaw('`team_player_points`.team_id = '.request('team'))

            ->whereRaw('fixtures.date_time BETWEEN gameweeks.start AND gameweeks.end')
            ->groupBy('player_id')
            ->groupBy('gameweeks.number')
            ->havingRaw('`gameweeks`.number = '.request('point'))
            ->with(['teamPoint', 'player', 'team',
                'player.playerContract',
                'player.playerContract.club', ]);
    }
}
