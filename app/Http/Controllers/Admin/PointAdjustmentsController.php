<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PointAdjustmentsDataTable;
use App\Enums\PointAdjustmentsEnum;
use App\Http\Controllers\Controller;
use App\Models\PointAdjustment;
use App\Models\Team;
use App\Services\PointAdjustmentService;
use Illuminate\Http\Request;

class PointAdjustmentsController extends Controller
{
    /**
     * @var PointAdjustmentService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param PointAdjustmentService $service
     */
    public function __construct(PointAdjustmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch the seasons data for datatable.
     *
     * @param SeasonsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function table(Request $request, Team $team)
    {
        return view('admin.teams.adjustments.table', compact('team'));
    }

    /**
     * Fetch the seasons data for datatable.
     *
     * @param SeasonsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PointAdjustmentsDataTable $dataTable, Team $team)
    {
        return $dataTable->with('team', $team)->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Team $team)
    {
        $competition_types = PointAdjustmentsEnum::toSelectArray();

        return view('admin.teams.adjustments.create', compact('team', 'competition_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->service->create($request->all())) {
            return ['message' => __('messages.data.saved.success')];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PointAdjustment $adjustment)
    {
        if ($adjustment->delete()) {
            return ['success' => true, 'message' => __('messages.data.deleted.success')];
        } else {
            return ['success' => false, 'message' => __('messages.data.deleted.error')];
        }
    }
}
