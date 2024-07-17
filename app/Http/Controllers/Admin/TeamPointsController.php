<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TeamPointsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use App\Services\TeamPointService;

class TeamPointsController extends Controller
{
    /**
     * @var service
     */
    protected $service;

    /**
     * TeamPointsController constructor.
     *
     * @param TeamPointService $service
     */
    public function __construct(TeamPointService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(TeamPointsDataTable $datatable)
    {
        return $datatable->ajax();
    }

    /**
     * Display a listing of the resource.
     * @param Team $team,Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team, $week)
    {
        return view('admin.teams.points.players', compact('team', 'week'));
    }
}
