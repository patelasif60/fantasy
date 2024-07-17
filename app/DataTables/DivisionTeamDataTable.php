<?php

namespace App\DataTables;

use App\Models\DivisionTeam;
use Yajra\DataTables\Services\DataTable;

class DivisionTeamDataTable extends DataTable
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
        ->addColumn('team', function ($data) {
            return $data->team->name;
        })
        ->addColumn('manager', function ($data) {
            return $data->team->consumer->user->first_name.' '.$data->team->consumer->user->last_name;
        })
        ->filter(function ($query) {
            // Check for the presence of search division_id in request.
            $query->when(request()->has('division_id'), function ($query) {
                return $query->where('division_id', request('division_id'));
            });

            // Check for the presence of search season in request.
            $query->when(request()->has('season'), function ($query) {
                return $query->where('season_id', request('season'));
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
            'team',
            'manager',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DivisionTeams_'.date('Y-m-d');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\PlayerStatus $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DivisionTeam $model)
    {
        return $model->newQuery()->select(
            'id',
            'division_id',
            'team_id',
            'season_id'
        );
    }
}
