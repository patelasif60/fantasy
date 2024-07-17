<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SeasonsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Season\RolloverRequest;
use App\Http\Requests\Season\StoreRequest;
use App\Http\Requests\Season\UpdateRequest;
use App\Models\GameWeek;
use App\Models\Season;
use App\Services\DivisionService;
use App\Services\SeasonService;

class SeasonsController extends Controller
{
    /**
     * @var SeasonService
     */
    protected $service;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * Create a new controller instance.
     *
     * @param SeasonService $service
     * @param DivisionService $divisionService
     */
    public function __construct(SeasonService $service, DivisionService $divisionService)
    {
        $this->service = $service;
        $this->divisionService = $divisionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.seasons.index');
    }

    /**
     * Fetch the seasons data for datatable.
     *
     * @param SeasonsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(SeasonsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = $this->service->getAllPackages();

        return view('admin.seasons.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['start_at'] = carbon_set_db_date($data['start_at']);
        $data['end_at'] = carbon_set_db_date($data['end_at']);

        $season = $this->service->create($data);

        if ($season) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.seasons.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Season $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season)
    {
        $packages = $this->service->getAllPackages();
        $phaseLeagueSeries = GameWeek::getLeagueSeries();
        $phaseProCup = GameWeek::getPhasesProCup();

        $leaguesCount = $this->divisionService->getPreviousSeasonDivisonCount();
        $phaseEuropaLeague = GameWeek::getPhasesEuropaLeague($leaguesCount);
        $phaseChampionsLeague = GameWeek::getPhasesChampionsLeague($leaguesCount);

        $seasons = Season::all()->except($season->id);

        return view('admin.seasons.edit', compact('season', 'seasons', 'packages', 'phaseLeagueSeries', 'phaseProCup', 'phaseChampionsLeague', 'phaseEuropaLeague'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Season $season
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Season $season)
    {
        $data = $request->all();
        $data['start_at'] = carbon_set_db_date($data['start_at']);
        $data['end_at'] = carbon_set_db_date($data['end_at']);
        $season = $this->service->update(
            $season,
            $data
        );

        if ($season) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.seasons.index');
    }

    /**
     * Rollover the specified resource in storage.
     *
     * @param  RolloverRequest  $request
     * @param  Season $season
     * @return \Illuminate\Http\Response
     */
    public function rollover(RolloverRequest $request, Season $season)
    {
        $season = $this->service->rollover(
            $season,
            $request->all()
        );

        if ($season) {
            flash('Leagues have been rollover successfully.')->success();
        } else {
            flash('Leagues could not be rollover at this time. Please try again later.')->error();
        }

        return redirect()->route('admin.seasons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Season $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season)
    {
        if ($season->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.seasons.index');
    }
}
