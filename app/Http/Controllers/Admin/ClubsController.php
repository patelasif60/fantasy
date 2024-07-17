<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClubsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Club\StoreRequest;
use App\Http\Requests\Club\UpdateRequest;
use App\Models\Club;
use App\Services\ClubService;

class ClubsController extends Controller
{
    /**
     * @var ClubService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param ClubService $service
     */
    public function __construct(ClubService $service)
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
        return view('admin.clubs.index');
    }

    /**
     * Fetch the clubs data for datatable.
     *
     * @param ClubsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(ClubsDataTable $dataTable)
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
        return view('admin.clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $club = $this->service->create($request->all());

        if ($club) {
            if ($request->hasFile('crest')) {
                $crest = $club->addMediaFromRequest('crest');
                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $crest->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $crest->toMediaCollection('crest');
            }
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.clubs.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        $crestObject = $club->getMedia('crest')->last();

        $crest = '';
        if ($crestObject) {
            $crest = [
                'name' => $crestObject->file_name,
                'type' => $crestObject->mime_type,
                'size' => $crestObject->size,
                'file' => $crestObject->getUrl('thumb'),
                'data' => [
                    'url' => $crestObject->getUrl('thumb'),
                    'id' => $crestObject->id,
                ],
            ];

            $crest = json_encode($crest);
        }

        return view('admin.clubs.edit', compact('club', 'crest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Club $club)
    {
        $club = $this->service->update(
            $club,
            $request->all()
        );

        if ($club) {
            if ($request->hasFile('crest')) {
                $crest = $club->addMediaFromRequest('crest');

                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $crest->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $crest->toMediaCollection('crest');
            } else {
                $returnVal = $request->imageShouldBeDeleted('crest');
                if ($returnVal) {
                    $this->service->crestDestroy($club);
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.clubs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        if (! $club->canBeDeleted()) {
            flash(__('messages.data.deleted.error'))->error();

            return redirect()->route('admin.clubs.index');
        }

        $this->service->crestDestroy($club);

        if ($club->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.clubs.index');
    }
}
