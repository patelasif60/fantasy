<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fixture\Lineup\StoreRequest;
use App\Http\Requests\Fixture\Lineup\UpdateRequest;
use App\Services\FixtureLineupService;

class FixtureLineupController extends Controller
{
    /**
     * FixtureLineupController constructor.
     *
     * @param FixtureLineupService $service
     */
    public function __construct(FixtureLineupService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a listing of the resource.
     * @param StoreRequest $request
     * @param $fixture_id
     * @return view with \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, $fixture_id)
    {
        $fixtureLineup = $this->service->store($request->all(), $fixture_id);

        if ($fixtureLineup) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.fixtures.edit', $fixture_id);
    }

    /**
     * Update a listing of the resource.
     * @param UpdateRequest $request
     * @param $fixture_id
     * @return view with \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $fixture_id)
    {
        $fixtureLineup = $this->service->update($request->all(), $fixture_id);

        if ($fixtureLineup) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.fixtures.edit', $fixture_id);
    }
}
