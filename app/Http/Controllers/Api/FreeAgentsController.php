<?php

namespace App\Http\Controllers\Api;

use App\DataTables\FreeAgentsListDataTable;
use App\Http\Controllers\Api\Controller as BaseController;
use App\Models\Division;
use App\Services\ClubService;
use App\Services\FreeAgentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FreeAgentsController extends BaseController
{
    const CLUB_PREMIER = 1;

    /**
     * @var FreeAgentService
     */
    protected $FreeAgentService;

    /**
     * @var clubService
     */
    protected $clubService;

    /**
     * FreeAgentsController constructor.
     *
     * @param FreeAgentService $freeAgentService
     * @param ClubService $clubService
     */
    public function __construct(FreeAgentService $freeAgentService, ClubService $clubService)
    {
        $this->freeAgentService = $freeAgentService;
        $this->clubService = $clubService;
    }

    public function getFreeAgents(Request $request, Division $division, FreeAgentsListDataTable $dataTable)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if (! $request->user()->can('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json( ['status' => 'success', 'data' => @$dataTable->ajax()->original, ], JsonResponse::HTTP_OK );
    }

    public function getFreeAgentsFilters(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if (! $request->user()->can('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data['positions'] = collect(($division->playerPositionEnum())::toSelectArray())->map(function ($key, $name) use ($division) {
            return  player_position_except_code($name).'s '.'('.$division->getPositionShortCode(player_position_short($name)).')';
        });

        $data['clubs'] = $this->clubService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $data['clubs'] = $data['clubs']->map(function ($item, $key) {
            return ['id' => $item->id, 'name' => $item->name];
        });

        return response()->json(['status' => 'success', 'data' => $data], JsonResponse::HTTP_OK);
    }

    public function exportPdf(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if (! $request->user()->can('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return ['success' => true, 'file' => $this->freeAgentService->exportPlayersApi($division, 'pdf')];
    }

    public function exportExcel(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if (! $request->user()->can('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return ['success' => true, 'file' => $this->freeAgentService->exportPlayersApi($division, 'excel')];
    }
}
