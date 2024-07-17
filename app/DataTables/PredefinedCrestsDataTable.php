<?php

namespace App\DataTables;

use App\Models\PredefinedCrest;
use Yajra\DataTables\Services\DataTable;

class PredefinedCrestsDataTable extends DataTable
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
        ->addColumn('image', function ($crestObj) {
            if ($crestObj->getMedia('crest')->last()) {
                return $crestObj->getMedia('crest')->last()->getUrl('thumb');
            } else {
                return config('fantasy.crest_50_na');
            }
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PredefinedCrest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PredefinedCrest $model)
    {
        return $model->newQuery()->select('id', 'name', 'is_published');
    }
}
