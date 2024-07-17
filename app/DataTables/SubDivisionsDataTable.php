<?php

namespace App\DataTables;

use App\Models\Division;
use Yajra\DataTables\Services\DataTable;

class SubDivisionsDataTable extends DataTable
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
        ->addColumn('chairman_name', function ($data) {
            return $data->consumer->user->first_name.' '.$data->consumer->user->last_name;
        })
        ->filter(function ($query) {
            // Check for the presence of search name in request.
            $query->when(request()->has('division_id'), function ($query) {
                return $query->where('parent_division_id', request('division_id'))->orWhere('id', request('division_id'));
            });
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Division $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Division $model)
    {
        return $model::select(
            'id',
            'name',
            'chairman_id'
        );
    }
}
