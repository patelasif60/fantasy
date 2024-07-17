<?php

namespace App\DataTables;

use App\Models\PlayerContract;
use Yajra\DataTables\Services\DataTable;

class PlayerContractDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->editColumn('start_date', function ($data) {
            if ($data->start_date) {
                return carbon_format_to_date($data->start_date);
            }
        })
        ->editColumn('end_date', function ($data) {
            if ($data->end_date) {
                return carbon_format_to_date($data->end_date);
            }
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\PlayerContract $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PlayerContract $model)
    {
        return $model->newQuery()->select('player_contracts.*')
            ->orderBy('start_date', 'desc')
            ->where('player_id', request('player'))
            ->with('club');
    }
}
