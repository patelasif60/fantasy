<?php

namespace App\DataTables;

use App\Models\Fixture;
use Yajra\DataTables\Services\DataTable;

class FixturesDatatable extends DataTable
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
            ->editColumn('date_time', function ($data) {
                if ($data->date_time) {
                    return carbon_format_to_time($data->date_time, true);
                }
            })
            ->filter(function ($query) {

             // Filter by Season.
                $query->when(request()->has('season'), function ($query) {
                    return $query->where('season_id', request('season'));
                });

                // Filter by Competition.
                $query->when(request()->has('competition'), function ($query) {
                    return $query->where('competition', request('competition'));
                });

                // Filter By Home Club.
                $query->when(request()->has('home_club'), function ($query) {
                    return $query->where('home_club_id', request('home_club'));
                });

                // Filter By Away Club.
                $query->when(request()->has('away_club'), function ($query) {
                    return $query->where('away_club_id', request('away_club'));
                });

                // Filter By Start Date.
                $query->when(request()->has('from_date_time'), function ($query) {
                    return $query->whereDate('date_time', '>=', carbon_set_db_date_time(request('from_date_time')));
                });

                // Filter By End Date.
                $query->when(request()->has('to_date_time'), function ($query) {
                    return $query->whereDate('date_time', '<=', carbon_set_db_date_time(request('to_date_time')));
                });
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Fixture $model)
    {
        return $model->newQuery()->select('fixtures.*')->with(['home_team', 'away_team',
        ]);
    }
}
