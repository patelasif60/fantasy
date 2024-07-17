<?php

namespace App\DataTables;

use App\Models\Package;
use Yajra\DataTables\Services\DataTable;

class PackagesDataTable extends DataTable
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
        ->filter(function ($query) {
            // Check for the presence of search name in request.
            $query->when(request()->has('name'), function ($query) {
                return $query->where('name', 'like', '%'.escape_like(request('name')).'%');
            });
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Package $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Package $model)
    {
        return $model->newQuery()->select(
            'id',
            'name',
            'display_name',
            'price',
            'minimum_teams'
        );
    }
}
