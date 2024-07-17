<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FixturesDatatable;
use App\Enums\CompetitionEnum;
use App\Http\Requests\Fixture\StoreRequest;
use App\Http\Requests\Fixture\UpdateRequest;
use App\Models\Fixture;
use App\Services\ClubService;
use App\Services\FixtureEventService;
use App\Services\FixtureLineupService;
use App\Services\FixtureService;
use App\Services\SeasonService;

class FixtureController extends Controller
{
    /**
     * @var FixtureService
     */
    protected $service;
    /**
     * @var ClubService
     */
    protected $clubService;
    /**
     * @var SeasonService
     */
    protected $seasonService;

    /**
     * @var FixtureEventService
     */
    protected $eventService;

    /**
     * @var FixtureLineupService
     */
    protected $lineupService;

    /**
     * FixtureController constructor.
     *
     * @param FixtureService $service
     * @param ClubService $clubService
     * @param SeasonService $seasonService
     * @param FixtureEventService $eventService
     * @param FixtureLineupService $lineupService
     */
    public function __construct(FixtureService $service, ClubService $clubService, SeasonService $seasonService, FixtureEventService $eventService, FixtureLineupService $lineupService)
    {
        $this->service = $service;
        $this->clubService = $clubService;
        $this->seasonService = $seasonService;
        $this->eventService = $eventService;
        $this->lineupService = $lineupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fixtures.index', [

            'seasons'       => $this->seasonService->getSeasonNames(),
            'competitions'  => CompetitionEnum::getValues(),
            'clubs'         => $this->clubService->getClubNames(),

        ]);
    }

    /**
     * Fetch the fixtures data for datatable.
     *
     * @param PlayersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(FixturesDatatable $dataTable)
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
        return view('admin.fixtures.create', [

            'seasons'       => $this->seasonService->getSeasonNames(),
            'competitions'  => CompetitionEnum::getValues(),
            'clubs'         => $this->clubService->getClubNames(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['time'] = manage_time_secound($data['time']);
        $data['date_time'] = carbon_set_db_date_time($data['date'].' '.$data['time']);

        $fixture = $this->service->create($data);

        if ($fixture) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.server_validation.date_overlap', ['messageobject'=>'Fixture', 'datefieldname'=>'Date']))->error();
        }

        return redirect()->route('admin.fixtures.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixture $fixture)
    {
        $competitions = CompetitionEnum::getValues();
        $seasons = $this->seasonService->getSeasonNames();
        $clubs = $this->clubService->getClubNames();

        return view(
            'admin.fixtures.edit',
            compact(
                'fixture',
                'seasons',
                'competitions',
                'clubs'
            )
            + $this->eventService->prepare_event_data($fixture, true)
            + $this->lineupService->getLineupData($fixture)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Fixture $fixture)
    {
        $data = $request->all();
        $data['time'] = manage_time_secound($data['time']);
        $data['date_time'] = carbon_set_db_date_time($data['date'].' '.$data['time']);
        $fixture = $this->service->update(
            $fixture,
            $data
        );

        if ($fixture) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.server_validation.date_overlap', ['messageobject'=>'Fixture', 'datefieldname'=>'Date']))->error();
        }

        return redirect()->route('admin.fixtures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fixture $fixture)
    {
        if ($fixture->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.fixtures.index');
    }
}
