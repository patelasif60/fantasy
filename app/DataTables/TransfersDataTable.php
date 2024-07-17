<?php

namespace App\DataTables;

use App\Models\DivisionTeam;
use App\Models\Team;
use App\Models\Transfer;
use Yajra\DataTables\Services\DataTable;

class TransfersDataTable extends DataTable
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
        ->addColumn('player_in', function ($data) {
            if ($data->player_in) {
                return get_player_name('fullName', $data->playerIn->first_name, $data->playerIn->last_name);
            }

            return '-';
        })
        ->addColumn('player_out', function ($data) {
            if ($data->playerOut) {
                return get_player_name('fullName', $data->playerOut->first_name, $data->playerOut->last_name);
            }

            return '-';
        })
        ->editColumn('transfer_date', function ($data) {
            return carbon_format_to_time($data->transfer_date);
        })

        ->filter(function ($query) {

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

            // Check for the transfer types if exist
            $query->when(request()->has('transfer_types'), function ($query) {
                if (! empty(request('transfer_types'))) {
                    return $query->whereIn('transfer_type', request('transfer_types'));
                }
            });

            // Check for the transfer types if not exist
            $query->unless(request()->has('transfer_types'), function ($query) {
                return $query->whereNull('transfer_type');
            });
        });
    }

    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'transfer_date',
            'transfer_type',
            'player_in',
            'player_out',
            'transfer_value',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transfer_'.date('Y-m-d');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transfer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transfer $model)
    {
        return $model->newQuery()->select(
            'id',
            'player_in',
            'player_out',
            'transfer_type',
            'transfer_value',
            'transfer_date'
        );
    }
}
