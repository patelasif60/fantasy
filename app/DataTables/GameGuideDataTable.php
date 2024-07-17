<?php

namespace App\DataTables;

use App\Models\GameGuide;
use Yajra\DataTables\Services\DataTable;

class GameGuideDataTable extends DataTable
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
     * @param \App\Models\GameGuide $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GameGuide $model)
    {
        return $model->newQuery()->select(
            'id',
            'section',
            'content',
            'order'
        )->orderBy('order');
    }
}
