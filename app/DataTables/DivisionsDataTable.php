<?php

namespace App\DataTables;

use App\Models\Season;
use App\Models\Division;
use App\Enums\Division\StatusEnum;
use Yajra\DataTables\Services\DataTable;

class DivisionsDataTable extends DataTable
{
    public $seasons;
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
        ->editColumn('name', function ($data) {

            if($data->divisionTeams) {

                $team = $data->divisionTeams->first();
                $season_id = $team ? $team->pivot->season_id : 0;
                $name = isset($this->seasons[$season_id]) ? $this->seasons[$season_id] : '';
                return $data->name.' - '.$name;
            }

            return $data->name;
        })
        // ->addColumn('email', function ($data) {
        //     return $data->consumer->user->email;
        // })
        ->filter(function ($query) {
            // Check for the presence of search name in request.
            $query->when(request()->has('name'), function ($query) {
                return $query->where('name', 'like', '%'.escape_like(request('name')).'%');
            });

            // Check for the chairman of league
            $query->when(request()->has('chairman_id'), function ($query) {
                return $query->where('chairman_id', request('chairman_id'));
            });

            $query->when(request()->has('season'), function ($query) {
                return $query->whereHas('divisionTeams', function ($query) {
                        return $query->where('season_id', request('season'));
                    });
            });

            $query->when(request()->has('status'), function ($query) {
                if (StatusEnum::ALLPAID == request('status')) {
                    return $query->whereHas('package', function ($query) {
                        return $query->where('price', 0);
                    })
                    ->orWhereHas('divisionTeams', function ($query) {
                        return $query->whereNotNull('payment_id');
                    });
                }

                if (StatusEnum::NOTPAID == request('status')) {
                    return $query->WhereHas('divisionTeams', function ($query) {
                        return $query->whereNull('payment_id');
                    })
                    ->whereHas('package', function ($query) {
                        return $query->where('price', '!=', 0);
                    });
                }
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
        $this->seasons = Season::pluck('name','id')->toArray();

        return $model::with('divisons','consumer.user')->select(
            'id',
            'name',
            'chairman_id'
        )
        ->active();
    }
}
