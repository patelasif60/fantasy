<?php

namespace App\DataTables;

use App\Models\Player;
use Yajra\DataTables\Services\DataTable;

class PlayersDataTable extends DataTable
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

                // Check for the presence of club of players
                $query->when(request()->has('club'), function ($query) {
                    $query->whereHas('PlayerContract', function ($query) {
                        return $query->where('club_id', request('club'))->active();
                    });
                });

                // Check for the presence of position of players
                $query->when(request()->has('position'), function ($query) {
                    $query->whereHas('PlayerContract', function ($query) {
                        return $query->where('position', request('position'))->active();
                    });
                });

                // Check for the presence of search name in request.
                $query->when(request()->has('term'), function ($query) {
                    return $query->where(function ($query) {
                        $query->where('first_name', 'like', '%'.escape_like(request('term')).'%')
                             ->orWhere('last_name', 'like', '%'.escape_like(request('term')).'%');
                    });
                });
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Club $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Player $model)
    {
        return $model::with('PlayerContract')->newQuery()->select(
            'players.*'
        );
    }
}
