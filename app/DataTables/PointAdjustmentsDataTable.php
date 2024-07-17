<?php

namespace App\DataTables;

use App\Enums\PointAdjustmentsEnum;
use App\Models\PointAdjustment;
use App\Models\Season;
use Yajra\DataTables\Services\DataTable;

class PointAdjustmentsDataTable extends DataTable
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
                ->editColumn('competition_type', function ($adjustment) {
                    return PointAdjustmentsEnum::getDescription($adjustment->competition_type);
                });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PointAdjustment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PointAdjustment $model)
    {
        return $model->newQuery()->select(
            'id',
            'points',
            'note',
            'competition_type'
        )
        ->where('team_id', $this->team->id)
        ->where('season_id', Season::getLatestSeason());
    }
}
