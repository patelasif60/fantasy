<?php

namespace App\Http\Controllers\Api;

use Storage;
use App\DataTables\HallofFameDataTable;
use App\DataTables\InjuredPlayersDataTable;
use App\DataTables\InsOutDataTable;
use App\DataTables\MorePlayerListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Season;
use App\Enums\EventsEnum;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use App\Services\DivisionService;
use App\Enums\PositionsEnum;
use App\Services\TeamLineupService;
use Illuminate\Http\JsonResponse;

class PlayersController extends Controller
{
    /**
     * @var PlayerService
     */
    protected $playerService;

    /**
     * PlayersController constructor.
     *
     * @param TeamLineupService $teamLineup
     */
    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function players(Division $division, MorePlayerListDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insout(Division $division, InsOutDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function history(Division $division, HallofFameDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    public function injuriesAndSuspensions(Division $division, InjuredPlayersDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    public function seasons(Request $request)
    {
        return ['seasons' => Season::orderBy('id', 'desc')->pluck('name', 'id')];
    }

    public function exportPdf(Request $request, Division $division)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return ['success' => true, 'file' => $this->playerService->exportPlayersApi($division, 'pdf')];
    }

    public function exportExcel(Request $request, Division $division)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return ['success' => true, 'file' => $this->playerService->exportPlayersApi($division, 'excel')];
    }

    public function historyLineupPage(Division $division, Request $request)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);
        $historyStats = $this->playerService->historyData($division, $request->all()['player_id']);

        return ['status' => 'success', 'data' => $historyStats];
    }

    public function playersDetails(Division $division, Request $request)
    {

        if (! $request->user('api')->can('isChairmanOrManagerOrParentleague', [$division, $request->user('api')->consumer->ownTeamDetails($division)])) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $playerDetails = $this->playerService->getPlayerDetails($request->get('player_id'));

        $currentSeason = Season::find(Season::getLatestSeason());
        $season = $currentSeason->isPreSeasonState() ? Season::find(Season::getPreviousSeason()) : $currentSeason;

        $teamLineup = app(TeamLineupService::class);

        $stats = $teamLineup->getPlayerStatsBySeasonSingle($division, $request->get('player_id'), $season->id);

        $stats = $stats[$request->get('player_id')];
        $historyStats = $this->playerService->historyDataWeb($request->get('player_id'));
        $historyData[] = [];

        $playerPositions = PositionsEnum::toSelectArray();
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);
        $count = 0;
        foreach ($historyStats as $historyStatsKey => $historyStatsValue) {
            $goal = isset($divisionPoints[$historyStatsValue->position][EventsEnum::GOAL]) && $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL] ? $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL] : 0;

            $assist = isset($divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST]) && $divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST] ? $divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST] : 0;

            $goalConceded = isset($divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED] : 0;

            $cleanSheet = isset($divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET] : 0;

            $appearance = isset($divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE]) && $divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE] ? $divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE] : 0;

            $historyData[$count]['name'] = $historyStatsValue->season->name;
            $historyData[$count]['played'] = $historyStatsValue->played;
            $historyData[$count]['appearance'] = $historyStatsValue->appearance;
            $historyData[$count]['goal'] = $historyStatsValue->goal;
            $historyData[$count]['assist'] = $historyStatsValue->assist;
            $historyData[$count]['clean_sheet'] = $historyStatsValue->clean_sheet;
            $historyData[$count]['goal_conceded'] = $historyStatsValue->goal_conceded;
            
            $historyData[$count]['total'] = $historyData[$count]['goal'] * $goal + $historyData[$count]['assist'] * $assist + $historyData[$count]['clean_sheet'] * $cleanSheet + $historyData[$count]['goal_conceded'] * $goalConceded + $historyData[$count]['appearance'] * $appearance;
            $count++;
        }

        return response()->json(['playerDetails' => $playerDetails, 'stats' => $stats ,'historyData' => $historyData, 'historyStats' => $historyStats ], JsonResponse::HTTP_OK);
    }
}
