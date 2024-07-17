<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PitchesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pitch\StoreRequest;
use App\Http\Requests\Pitch\UpdateRequest;
use App\Models\Pitch;
use App\Services\PitchService;
use Illuminate\Http\Request;

class PitchesController extends Controller
{
    /**
     * @var PitchService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param PitchService $service
     */
    public function __construct(PitchService $service)
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
        return view('admin.pitches.index');
    }

    /**
     * Fetch the pitches data for datatable.
     *
     * @param PitchesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PitchesDataTable $dataTable)
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
        return view('admin.pitches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $pitch = $this->service->create($request->all());

        if ($pitch) {
            if ($request->hasFile('crest')) {
                $crest = $pitch->addMediaFromRequest('crest');

                $manipulations = [];
                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $manipulations['manualCrop'] = $request->getCropParameters($crop);
                }
                if ($rotation = $request->imageShouldBeRotated('crest')) {
                    $manipulations['orientation'] = 360 - (int) $rotation;
                }
                $crest->withManipulations([
                    'thumb' => $manipulations,
                ]);
                $crest->toMediaCollection('crest');
            }
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.pitches.index');
    }

    public function checkUniquePitch(Request $request)
    {
        if ($this->service->check($request->all())) {
            return 'false';
        } else {
            return 'true';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pitch $pitch)
    {
        $crestObject = $pitch->getMedia('crest')->last();

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
                    'readerForce'=> true,
                ],
            ];

            $crest = json_encode($crest);
        }

        return view('admin.pitches.edit', compact('pitch', 'crest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Pitch $pitch)
    {
        $pitch = $this->service->update(
            $pitch,
            $request->all()
        );

        if ($pitch) {
            if ($request->hasFile('crest')) {
                $crest = $pitch->addMediaFromRequest('crest');

                $manipulations = [];
                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $manipulations['manualCrop'] = $request->getCropParameters($crop);
                }
                if ($rotation = $request->imageShouldBeRotated('crest')) {
                    $manipulations['orientation'] = 360 - (int) $rotation;
                }
                $crest->withManipulations([
                    'thumb' => $manipulations,
                ]);
                $crest->toMediaCollection('crest');
            } else {
                $returnVal = $request->imageShouldBeDeleted('crest');
                if ($returnVal) {
                    $this->service->crestDestroy($pitch);
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.pitches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pitch $pitch)
    {
        $this->service->crestDestroy($pitch);

        if ($pitch->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.pitches.index');
    }
}
