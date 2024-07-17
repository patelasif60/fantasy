<?php

namespace App\DataTables;

use App\Models\DivisionTeam;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPoint;
use App\Models\Transfer;
use Yajra\DataTables\Services\DataTable;

class TeamPlayersDatatable extends DataTable
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
        ->addColumn('points', function ($data) {
            $fixtures = Fixture::where('season_id', request('season'))
                                    ->where('status', 'Played')
                                    ->where('competition', 'Premier League')
                                    ->pluck('id');

            $teamPoins = TeamPoint::whereIn('fixture_id', $fixtures)
                                    ->where('team_id', $data->team->id)
                                    ->pluck('id');

            return  TeamPlayerPoint::where('player_id', $data->player->id)
                                        ->where('team_id', $data->team->id)
                                        ->whereIn('team_point_id', $teamPoins)
                                        ->sum('total');

            // return  TeamPlayerPoint::where('player_id', $data->player->id)->where('team_id', $data->team->id)->sum('total');
           // return ($data->player->teamPlayerPoints) ? $data->player->teamPlayerPoints->where('team_id', request('team'))->sum('total') : '0';
        })
        ->addColumn('bid', function ($data) {
            // $playerValue = $data->team->transfer->where('player_in', $data->player->id)->last();
            // return $playerValue ? $playerValue->transfer_value : '0';
            $transfer_value = Transfer::where('player_in', $data->player->id)->where('team_id', $data->team->id)->orderBy('transfers.transfer_date', 'desc')->select('transfers.transfer_value')->first();

            return $transfer_value ? $transfer_value->transfer_value : 0;
        })
        ->filter(function ($query) {
            $query->when(request()->has('player'), function ($query) {
                // Please set the squad condition here
                if (request('player') == 'squad') {
                    $query->whereNull('end_date');
                }

                return $query;
            });

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
                $query->where('team_id', request('team'));
            });

            return $query->groupPlayerContracts();
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TeamPlayer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TeamPlayerContract $model)
    {
        return $model->newQuery()->select(['player_id', 'team_id'])->with(['player', 'player.playerContract', 'player.playerContract.club', 'team']);
    }
}
