<?php

namespace App\DataTables;

use App\Models\PlayerStatus;
use Yajra\DataTables\Services\DataTable;

class PlayerStatusDataTable extends DataTable
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
        ->editColumn('start_date', function ($data) {
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
     * @param \App\PlayerStatus $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PlayerStatus $model)
    {
        return $model->newQuery()->select('player_status.*')->where('player_id', request('player'));
    }
}
