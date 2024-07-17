<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PredefinedCrestsDataTable;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Options\Crests\StoreRequest;
use App\Http\Requests\Options\Crests\UpdateRequest;
use App\Models\PredefinedCrest;
use App\Services\PredefinedCrestService;
use Illuminate\Http\Request;
use JavaScript;

class PredefinedCrestsController extends Controller
{
    /**
     * @var CrestsService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param CrestsService $service
     */
    public function __construct(PredefinedCrestService $service)
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
        JavaScript::put([
            'status' => YesNoEnum::toArray(),
        ]);

        return view('admin.options.crests.index');
    }

    /**
     * Fetch the crests data for datatable.
     *
     * @param CrestsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PredefinedCrestsDataTable $dataTable)
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
        JavaScript::put([
            'crest_check_url' => route('admin.options.crests.check'),
        ]);

        return view('admin.options.crests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $crestData = $this->service->create($request->all());

        if ($crestData) {
            if ($request->hasFile('crest')) {
                $crest = $crestData->addMediaFromRequest('crest');
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

        return redirect()->route('admin.options.crests.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PredefinedCrest  $crestData
     * @return \Illuminate\Http\Response
     */
    public function edit(PredefinedCrest $crest)
    {
        JavaScript::put([
            'crest_check_url' => route('admin.options.crests.check'),
        ]);

        $crestData = $crest;
        $crestObject = $crestData->getMedia('crest')->last();

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

        return view('admin.options.crests.edit', compact('crestData', 'crest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  PredefinedCrest  $crestData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, PredefinedCrest $predefined_crest)
    {
        $crestData = $predefined_crest;

        $crestData = $this->service->update(
            $crestData,
            $request->all()
        );

        if ($crestData) {
            if ($request->hasFile('crest')) {
                $crest = $crestData->addMediaFromRequest('crest');

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
                    $this->service->crestDestroy($crestData);
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.options.crests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PredefinedCrest  $crestData
     * @return \Illuminate\Http\Response
     */
    public function destroy(PredefinedCrest $crest)
    {
        if ($crest->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.options.crests.index');
    }

    public function check(Request $request)
    {
        if ($this->service->check($request->all())) {
            return 'false';
        } else {
            return 'true';
        }
    }
}
