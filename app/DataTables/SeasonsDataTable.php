<?php

namespace App\DataTables;

use App\Models\Season;
use Yajra\DataTables\Services\DataTable;

class SeasonsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Season $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Season $model)
    {
        return $model->newQuery()->select(
            'id',
            'name',
            'premier_api_id',
            'facup_api_id'
        );
    }
}
