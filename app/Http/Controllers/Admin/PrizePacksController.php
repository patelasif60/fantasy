<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PrizePacksDataTable;
use App\Enums\BadgeColorEnum;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrizePack\StoreRequest;
use App\Http\Requests\PrizePack\UpdateRequest;
use App\Models\PrizePack;
use App\Services\PrizePackService;

class PrizePacksController extends Controller
{
    /**
     * @var PrizePackService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param PrizePackService $service
     */
    public function __construct(PrizePackService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.prizepacks.index');
    }

    /**
     * Fetch the packages data for datatable.
     *
     * @param PrizePacksDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PrizePacksDataTable $dataTable)
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
        $yesNo = YesNoEnum::toSelectArray();
        $badgeColors = BadgeColorEnum::toSelectArray();

        return view('admin.prizepacks.create', compact('yesNo', 'badgeColors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $prizePack = $this->service->create($data);

        if ($prizePack) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.prizepacks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PrizePack  $prizePack
     * @return \Illuminate\Http\Response
     */
    public function edit(PrizePack $prizePack)
    {
        $yesNo = YesNoEnum::toSelectArray();
        $badgeColors = BadgeColorEnum::toSelectArray();

        return view('admin.prizepacks.edit', compact('prizePack', 'yesNo', 'badgeColors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  PrizePack $prizePack
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, PrizePack $prizePack)
    {
        $data = $request->all();
        $prizePack = $this->service->update(
            $prizePack,
            $data
        );

        if ($prizePack) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.prizepacks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PrizePack $prizePack
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrizePack $prizePack)
    {
        if ($prizePack->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.prizepacks.index');
    }
}
