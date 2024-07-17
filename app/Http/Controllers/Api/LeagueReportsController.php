<?php

namespace App\Http\Controllers\Api;

use App\Enums\PlayerContractPositionEnum;
use App\Http\Controllers\Api\Controller as BaseController;
use App\Http\Resources\Club;
use App\Http\Resources\LeagueReport;
use App\Http\Resources\LeagueReportCollection;
use App\Http\Resources\Team;
use App\Models\Division;
use App\Services\ClubService;
use App\Services\LeagueReportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeagueReportsController extends BaseController
{
    /**
     * @var LeagueReportService
     */
    protected $service;

    /**
     * @var ClubService
     */
    protected $clubService;

    /**
     * LeagueReportsController constructor.
     *
     * @param LeagueReportService $service
     */
    public function __construct(LeagueReportService $service, ClubService $clubService)
    {
        $this->service = $service;
        $this->clubService = $clubService;
    }

    public function players(Request $request, $league)
    {
        $players = $this->service->getDivisionPlayers($league, $request->all());

        return  new LeagueReportCollection($players);
    }

    public function index()
    {
        return response()->json([
            'positions' => array_values(PlayerContractPositionEnum::toArray()),
            'clubs' => Club::collection($this->clubService->list()),
        ]);
    }

    public function leagueTeams(Division $division)
    {
        return response()->json([
            'data' => Team::collection($division->divisionTeams->load('consumer')),
        ]);
    }

    public function teamPlayers(Division $division, $team)
    {
        $players = $this->service->getDivisionTeamPlayers($division->id, $team);

        return response()->json([
            'data' => LeagueReport::collection($players),
        ]);
    }

//     public function sendEmail(Division $division)
//     {
//     $email = $this->service->sendEmail($division, auth()->user());
    public function sendEmail(\Illuminate\Http\Request $request, Division $division)
    {
        $email = $this->service->sendEmail($division, $request->user());
        $status_code = Response::HTTP_OK;
        $status = 'success';

        if ($email) {
            $message = trans('League Report will soon be mailed to you');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $status = 'error';
            $message = trans('Please try again later!');
        }

        return response()->json(['message'=>$message, 'status'=>$status], $status_code);
    }
}
