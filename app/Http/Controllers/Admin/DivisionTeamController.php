<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DivisionTeamDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Division\Team\StoreRequest;
use App\Http\Requests\Division\Team\UpdateRequest;
use App\Models\Division;
use App\Models\DivisionTeam;
use App\Services\DivisionTeamService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DivisionTeamController extends Controller
{
    /**
     * @var DivisionTeamService
     */
    protected $service;

    /**
     * @var ClubService
     */
    protected $clubservice;

    /**
     * DivisionTeamController constructor.
     *
     * @param DivisionTeamService $service
     */
    public function __construct(DivisionTeamService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch the division team data for datatable.
     *
     * @param DivisionTeamDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(DivisionTeamDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($division_id, $season_id)
    {
        $teams = $this->service->getTeams();
        $seasons = $this->service->getSeasons();

        return view('admin.divisions.team.create', compact('seasons', 'teams', 'division_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DivisonTeamStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $division = $this->service->create($request->all());
        $status_code = Response::HTTP_OK;

        if ($division) {
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
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(DivisionTeam $divisonteam)
    {
        $teams = $this->service->getTeams($divisonteam->team_id);
        $seasons = $this->service->getSeasons();

        return view('admin.divisions.team.edit', ['seasons' => $seasons, 'teams'=>$teams, 'divisonteam' => $divisonteam]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param DivisionTeam $DivisionTeam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, DivisionTeam $divisonteam)
    {
        $divisonteam = $this->service->update($divisonteam, $request->all());

        $status_code = Response::HTTP_OK;
        if ($divisonteam) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('messages.data.saved.error');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    public function destroy(Division $division, DivisionTeam $divisonteam)
    {
        if ($divisonteam->delete()) {
            flash('Division Team deleted successfully')->success();
        } else {
            flash('Division Team could not be deleted. Please try again.')->error();
        }

        return redirect()->route('admin.divisions.edit', ['division'=> $division]);
    }

    public function team($division_id, $season_id)
    {
        $teams = $this->service->getTeams();

        if ($teams) {
            $status_code = Response::HTTP_OK;
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json(['teams'=>$teams], $status_code);
    }

    /**
     * Fetch the division team data for export.
     *
     * @param UsersDataTable $dataTable
     */
    public function export(DivisionTeamDataTable $dataTable)
    {
        return $dataTable->csv();
    }

    /**
     * Fetch the division team data for export.
     *
     * @param Illuminate\Http\Request;
     * @param Division Division_id
     */
    public function recalculatePoints(Request $request, $division_id)
    {
        $points = $this->service->recalculatePoints($division_id);

        return response()->json(['status' => 'success', 'message' => 'Point re-calculation has started successfully. It will take time.'], Response::HTTP_OK);

        // $status_code = Response::HTTP_OK;
        // if ($points) {
        //     $message = trans('messages.data.saved.success');
        // } else {
        //     $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
        //     $message = trans('Points are already calculated for the teams. Thank You!');
        // }

        // return response()->json(['message'=> $message, 'errors' => ['message' => [ $message]]], $status_code);
    }
}
