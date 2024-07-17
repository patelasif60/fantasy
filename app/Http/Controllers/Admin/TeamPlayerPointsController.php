<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\TeamPlayerPointsService;
use App\DataTables\TeamPlayerPointsDataTable;
use App\Http\Requests\Team\Player\Point\UpdateRequest;

class TeamPlayerPointsController extends Controller
{
    /**
     * @var TeamPlayerPointsService
     */
    protected $service;

    /**
     * TeamPlayerPointsController constructor.
     *
     * @param TeamPlayerPointsService $service
     */
    public function __construct(TeamPlayerPointsService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(TeamPlayerPointsDataTable $datatable)
    {
        return $datatable->ajax();
    }

    /**
     * Display a listing of points after recalculation.
     * @param Team $team
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function recalculate(UpdateRequest $request, Team $team, Player $player)
    {
        ini_set('memory_limit', '-1');

        $recalculate = $this->service->recalculate($request->all(), $team, $player);
        $status_code = Response::HTTP_OK;

        if ($recalculate) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('Points are already added for the player. Thanks You');
        }

        return response()->json(['message'=> $message, 'errors' => ['message' => [$message]]], $status_code);
    }
}
