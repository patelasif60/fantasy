<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FixtureEventDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fixture\Events\StoreRequest;
use App\Http\Requests\Fixture\Events\UpdateRequest;
use App\Models\Fixture;
use App\Models\FixtureEvent;
use App\Services\FixtureEventService;
use App\Services\FixtureStatService;
use Illuminate\Http\Response;

class FixtureEventsController extends Controller
{
    /**
     * @var FixtureEventsService
     */
    protected $service;

    /**
     * @var FixtureStatService
     */
    protected $fixtureStatService;

    /**
     * FixtureEventsController constructor.
     *
     * @param FixtureEventService $service
     */
    public function __construct(FixtureEventService $service, FixtureStatService $fixtureStatService)
    {
        $this->service = $service;
        $this->fixtureStatService = $fixtureStatService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  FixtureEventDataTable $dataTable
     * @param  $fixture_id
     * @return \Illuminate\Http\Response
     */
    public function data(FixtureEventDataTable $dataTable, $fixture_id)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     * @param  Fixture $fixture
     * @return \Illuminate\Http\Response
     */
    public function create(Fixture $fixture)
    {
        return view('admin.fixtures.event.create', $this->service->prepare_event_data($fixture));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $fixture_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($fixture_id, StoreRequest $request)
    {
        $event = $this->service->create($request->all());

        $this->fixtureStatService->createFixtureStatAfterStore($event);

        $status_code = Response::HTTP_OK;

        if ($event) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('messages.data.saved.error');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fixture  $fixture
     * @param  \App\Models\FixtureEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixture $fixture, FixtureEvent $event)
    {
        return view('admin.fixtures.event.edit', $this->service->prepare_event_data($fixture, false, $event));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fixture       $fixture
     * @param  \App\Models\FixtureEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Fixture $fixture, FixtureEvent $event)
    {
        $isUpdate = $this->fixtureStatService->isEventUpdate($event, $request->all());
        $eventDetailsOld = $event->details;

        $event = $this->service->update(
            $event,
            $request->all()
        );

        $event = FixtureEvent::find($event->id);

        if (! $isUpdate) {
            $this->fixtureStatService->isPlayerUpdate($event, $eventDetailsOld);
        }

        $this->fixtureStatService->createFixtureStatAfterStore($event);

        $status_code = Response::HTTP_OK;
        if ($event) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('messages.data.saved.error');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FixtureEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixtureEvent $event)
    {
        $this->fixtureStatService->updateFixtureStatBeforeDelete($event);

        if ($event->delete()) {
            flash('Fixture Event deleted successfully')->success();
        } else {
            flash('Fixture Event could not be deleted. Please try again.')->error();
        }

        return redirect()->route('admin.fixtures.edit', ['fixture'=> $event->fixture_id]);
    }
}
