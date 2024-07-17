<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TeamPlayersDatatable;
use App\Http\Controllers\Controller;
use App\Services\TeamPlayerService;

class TeamPlayerController extends Controller
{
    /**
     * @var service
     */
    protected $service;

    /**
     * TeamPlayerController constructor.
     *
     * @param TeamPlayerService $service
     */
    public function __construct(TeamPlayerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @param App\DataTables\TeamPlayerDatatable
     * @return \Illuminate\Http\Response
     */
    public function data(TeamPlayersDatatable $dataTable)
    {
        return $dataTable->ajax();
    }
}
