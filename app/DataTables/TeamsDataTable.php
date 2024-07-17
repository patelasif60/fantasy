<?php

namespace App\DataTables;

use App\Models\Team;
use App\Models\Season;
use Yajra\DataTables\Services\DataTable;

class TeamsDataTable extends DataTable
{
    public $teamIdsArray = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('manager', function ($data) {
            return $data->consumer->user->first_name.' '.$data->consumer->user->last_name;
        })
        ->addColumn('email', function ($data) {
            return $data->consumer->user->email;
        })
        ->addColumn('division', function ($data) {
            if (! $data->teamDivision->count()) {
                return '';
            }

            return $data->teamDivision->last()->name;
        })
        ->editColumn('name', function ($data) {

            if($data->teamDivision) {
                $division = $data->teamDivision->first();
                $season_id = $division ? $division->pivot->season_id : 0;
                $name = isset($this->seasons[$season_id]) ? $this->seasons[$season_id] : '';
                return $data->name.' - '.$name;
            }

            return $data->name;
        })
        ->addColumn('status', function ($data) {
            if (! $data->teamDivision->count()) {
                return '';
            }

            $isPaid = $this->isPaid($data);

            if ($isPaid == 1) {
                return 'Paid (active)';
            } elseif ($isPaid == 'strike') {
                return 'Free';
            }

            return 'Not Paid (inactive)';
        })
        ->addColumn('isUnpaid', function ($data) {
            if (! $data->teamDivision->count()) {
                return false;
            }

            $isPaid = $this->isPaid($data);
            if ($isPaid == 1 || $isPaid == 'strike') {
                return false;
            }

            return true;
        })
        ->addColumn('paidStatus', function ($data) {
            if (! $data->teamDivision->count()) {
                return '';
            }

            $isPaid = $this->isPaid($data);
            if ($isPaid == 1) {
                return true;
            }

            return false;
        })
        ->filter(function ($query) {
            // Check for the presence of search name in request.
            $query->when(request()->has('name'), function ($query) {
                return $query->where('name', 'like', '%'.escape_like(request('name')).'%');
            });
            $query->when(request()->has('division_id'), function ($query) {
                $query->whereHas('teamDivision', function ($query) {
                    return $query->where('division_id', request('division_id'));
                });
            });
            // Check for the chairman of league
            $query->when(request()->has('manager_id'), function ($query) {
                return $query->where('manager_id', request('manager_id'));
            });
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Team $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Team $model)
    {
        $this->seasons = Season::pluck('name','id')->toArray();

        return $model->newQuery()
                    ->with('teamDivision','consumer.user')
                    ->where('is_approved', 1)
                    ->select(
                        'id',
                        'name',
                        'manager_id'
                    );
    }

    public function isPaid($data)
    {
        if (isset($this->teamIdsArray[$data->id])) {
            $isPaid = $this->teamIdsArray[$data->id];
        } else {
            $isPaid = $data->isPaid();
            $this->teamIdsArray[$data->id] = $isPaid;
        }

        return $isPaid;
    }
}
