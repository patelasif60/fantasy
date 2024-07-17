<?php

namespace App\DataTables;

use App\Models\PrizePack;
use Yajra\DataTables\Services\DataTable;

class PrizePacksDataTable extends DataTable
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
     * @param \App\Models\Package $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PrizePack $model)
    {
        return $model->newQuery()->select(
            'id',
            'name',
            'price',
            'short_description',
            'long_description',
            'is_enabled'
        );
    }
}
