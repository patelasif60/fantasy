<?php

namespace App\DataTables;

use App\Models\Club;
use Yajra\DataTables\Services\DataTable;

class ClubsDataTable extends DataTable
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
            ->editColumn('is_premier', function ($club) {
                if ($club->is_premier) {
                    return 'Premier League';
                } else {
                    return '-';
                }
            })
            ->addColumn('can_be_deleted', function ($club) {
                return $club->canBeDeleted();
            })
            ->addColumn('image', function ($club) {
                if ($club->getMedia('crest')->last()) {
                    return $club->getMedia('crest')->last()->getUrl('thumb');
                } else {
                    return config('fantasy.crest_50_na');
                }
            })
            ->filter(function ($query) {
                // Check for the presence of search name in request.
                $query->when(request()->has('name'), function ($query) {
                    return $query->where('name', 'like', '%'.escape_like(request('name')).'%');
                });

                // Check for the premier league checked or not
                $query->when(request()->has('is_premier'), function ($query) {
                    return $query->where('is_premier', request('is_premier'));
                });
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Club $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Club $model)
    {
        return $model->newQuery()->select(
            'id',
            'api_id',
            'name',
            'is_premier'
        );
    }
}
