<?php

namespace App\DataTables;

use App\Models\FixtureEvent;
use Yajra\DataTables\Services\DataTable;

class FixtureEventDataTable extends DataTable
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
            ->addColumn('second', function ($data) {
                return $data->second;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\FixtureEvent $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FixtureEvent $model)
    {
        return $model->newQuery()->select('fixture_events.*')->where('fixture_id', request('fixture'))->with('club', 'eventType', 'player', 'subPlayer', 'details', 'details.player')->orderBy('half', 'desc');
    }
}
