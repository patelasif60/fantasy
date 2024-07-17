<?php

namespace App\Http\Controllers\Admin;

use JavaScript;
use App\Models\Team;
use App\Models\Season;
use App\Models\Consumer;
use App\Models\Division;
use App\Services\TeamService;
use Illuminate\Http\Response;
use App\Enums\TransferTypeEnum;
use App\DataTables\TeamsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Team\StoreRequest;
use App\Http\Requests\Team\UpdateRequest;

class TeamsController extends Controller
{
    /**
     * @var TeamService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param TeamService $service
     */
    public function __construct(TeamService $service)
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
        $divisions = [];
        $managers = [];

        return view('admin.teams.index', compact('divisions', 'managers'));
    }

    /**
     * Fetch the teams data for datatable.
     *
     * @param TeamsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(TeamsDataTable $dataTable)
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
        $pitches = $this->service->getPitches();
        $season = Season::getLatestSeason();
        $divisions = $this->service->getDivisions($season);
        $managers = []; //$this->service->getConsumers();
        $crests = $this->service->getPredefinedCrests();
        $pitches = $this->service->getPitches();

        return view('admin.teams.create', compact('managers', 'divisions', 'crests', 'pitches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user = Consumer::find($request['manager_id']);
        $request['email'] = $user->user->email;

        $division = Division::find($request['division_id']);
        $request['max_free_places'] = $division->package->max_free_places;
        $request['private_league'] = $division->package->private_league;

        if ($division->package->private_league == 'No') {
            $team = $division->divisionTeams()->where('manager_id', $request['manager_id']);
            if ($team->count() > 0) {
                flash(__('Manager already have a team in this Social League'))->error();

                return redirect()->route('admin.teams.index');
            }
        }

        $team = $this->service->create($request->all());
        if ($team) {
            if ($request->hasFile('crest')) {
                $crest = $team->addMediaFromRequest('crest');
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
            $this->service->sendTeamConformationMail($team);
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.teams.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeTeam(StoreRequest $request)
    {
        $division = Division::find($request['division_id']);
        $request['max_free_places'] = $division->package->max_free_places;
        $request['private_league'] = $division->package->private_league;

        if ($division->package->private_league == 'No') {
            $team = $division->divisionTeams()->where('manager_id', $request['manager_id']);
            if ($team->count() > 0) {
                $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;

                return response()->json(['message'=>'Manager already have a team in this Social League', 'errors'=>['message'=>['Manager already have a team in this Social League']]], $status_code);
            }
        }

        $user = Consumer::find($request['manager_id']);
        $request['email'] = $user->user->email;

        $team = $this->service->create($request->all());
        $status_code = Response::HTTP_OK;

        if ($team) {
            if ($request->hasFile('crest')) {
                $crest = $team->addMediaFromRequest('crest');
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
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $season = $team->divisionTeam->season_id;
        $divisions = $this->service->getDivisions($season);
        $managers = $this->service->getManager($team);
        $transfer_type = TransferTypeEnum::toSelectArray();
        $crestObject = $team->getMedia('crest')->last();
        $crests = $this->service->getPredefinedCrests();
        $pitches = $this->service->getPitches();
        $seasons = $this->service->getTeamSeasons();
        $teamDivision = $team->teamDivision->first();
        JavaScript::put([
            'transferType' => TransferTypeEnum::toSelectArray(),
            'substitution' => TransferTypeEnum::SUBSTITUTION,
            'superSub' => TransferTypeEnum::SUPERSUB,
            'budgetCorrection' => TransferTypeEnum::BUDGETCORRECTION,
            'team' => $team,
        ]);

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

        return view('admin.teams.edit', compact('team', 'crest', 'managers', 'divisions', 'transfer_type', 'crests', 'pitches', 'seasons', 'teamDivision'));
    }

    public function recalculatePoints(Team $team)
    {
        $team = $this->service->recalculatePoints(
            $team,
            auth()->user()->email
        );

        return response()->json(['status' => 'success', 'message' => 'Point re-calculation has started successfully. It will take time.'], JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Team $team)
    {
        $team = $this->service->update(
            $team,
            $request->all()
        );

        if ($team) {
            if ($request->hasFile('crest')) {
                $crest = $team->addMediaFromRequest('crest');
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
                    $this->service->crestDestroy($team);
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if ($team->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.teams.index');
    }

    public function markAsUnPaid(Team $team)
    {
        if ($this->service->markAsUnPaid($team)) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.teams.index');
    }

    public function markAsPaid(Team $team)
    {
        if ($this->service->markAsPaid($team)) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.teams.index');
    }
}
