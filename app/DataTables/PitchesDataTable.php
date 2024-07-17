<?php

namespace App\DataTables;

use App\Models\Pitch;
use Yajra\DataTables\Services\DataTable;

class PitchesDataTable extends DataTable
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
     * @param \App\Models\Pitch $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Pitch $model)
    {
        return $model->newQuery()->select(
            'id',
            'name',
            'is_published'
        );
    }
}
