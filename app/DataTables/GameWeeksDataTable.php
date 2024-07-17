<?php

namespace App\DataTables;

use App\Models\GameWeek;
use Yajra\DataTables\Services\DataTable;

class GameWeeksDataTable extends DataTable
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
                ->editColumn('start', function ($gameWeek) {
                    return carbon_format_to_date($gameWeek->start);
                })
                ->editColumn('end', function ($gameWeek) {
                    return carbon_format_to_date($gameWeek->end);
                });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GameWeek $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GameWeek $model)
    {
        return $model->newQuery()->select(
            'id',
            'number',
            'is_valid_cup_round',
            'start',
            'end',
            'notes'
        )->where('season_id', $this->season->id);
    }
}
