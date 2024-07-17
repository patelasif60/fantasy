<?php

namespace App\Http\Controllers\Manager;

use App\DataTables\DivisionPlayersReportDataTable;
use App\DataTables\DivisionTeamPlayersReportDataTable;
use App\Enums\PlayerContractPositionEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Team;
use App\Services\LeagueReportService;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class LeagueReportsController extends Controller
{
    const CLUB_PREMIER = 1;

    /**
     * @var LeagueReport
     */
    protected $leagueReportService;

    /**
     * LeagueReportsController constructor.
     *
     * @param LeagueReportService $service
     */
    public function __construct(LeagueReportService $leagueReportService)
    {
        $this->leagueReportService = $leagueReportService;
    }

    public function index(Division $division)
    {
        return abort(403);

        return view(
            'manager.leaguereports.index',
            compact('division'),
            $this->leagueReportService->getDivisionReportData($division)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function team(Division $division, $team = null)
    {
        if (! $team) { // take divition teams first team as default team
            $teamData['team_id'] = Arr::get($division, 'divisionTeams.0.id');
            $teamData['team_name'] = Arr::get($division, 'divisionTeams.0.name');
            $teamData['manager_name'] = Arr::get($division, 'divisionTeams.0.consumer.user.first_name').' '.Arr::get($division, 'divisionTeams.0.consumer.user.last_name');
            $teamData['team_crest'] = Arr::has($division, 'divisionTeams.0') ? $division->divisionTeams[0]->getCrestImageThumb() : '';
        } else { // team id is passed
            $data = $this->leagueReportService->getTeam($team);
            $teamData['team_id'] = $team;
            $teamData['team_name'] = Arr::get($data, 'name');
            $teamData['manager_name'] = Arr::get($data, 'consumer.user.first_name').' '.Arr::get($data, 'consumer.user.last_name');
            $teamData['team_crest'] = $data->getCrestImageThumb();
        }
        $teamData['remaining_budget'] = rand(20, 80) / 10;

        return view('manager.leaguereports.team', compact('division', 'teamData'));
    }

    public function teamPlayersData(Division $division, DivisionTeamPlayersReportDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function division(Division $division)
    {
        return view(
            'manager.leaguereports.league',
            compact('division'),
            $this->leagueReportService->getDivisionReportData($division)
        );
    }

    public function sendEmail(\Illuminate\Http\Request $request, Division $division)
    {
        $email = $this->leagueReportService->sendEmail($division, $request->user());
        $status_code = Response::HTTP_OK;

        if ($email) {
            $message = trans('League Report will soon be mailed to you');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('Please try again later!');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    public function player(Division $division)
    {
        $clubs = $this->leagueReportService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $positions = PlayerContractPositionEnum::toArray();

        return view('manager.leaguereports.player', compact('division', 'positions', 'clubs'));
    }

    /**
     * Fetch the players of division data for datatable.
     *
     * @param TeamsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function players(Division $division, DivisionPlayersReportDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}
