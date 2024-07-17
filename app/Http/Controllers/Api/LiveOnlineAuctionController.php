<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\LiveOnlineAuctionService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiveOnlineAuctionController extends Controller
{
    protected $service;

    public function __construct(LiveOnlineAuctionService $service)
    {
        $this->service = $service;
    }

    public function start(Request $request, Division $division)
    {
        $isMobile = true;
        $data = $this->service->getTeamManagers($request, $division, $isMobile);
        $data['currentDateTime'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['teamDetails'] = auth()->user()->consumer->ownTeamDetails($division);

        return response()->json(
            ['status' => 'success',
                'data' => $data,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function searchPlayers(Request $request, Division $division)
    {
        $players = $this->service->searchPlayers($request, $division);

        return response()->json(
            ['status' => 'success',
                'data' => $players,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function getPlayers(Request $request, Division $division)
    {
        $players = $this->service->getPlayers($request, $division);

        return response()->json(
            ['status' => 'success',
                'data' => $players,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function playerSold(Request $request, $division)
    {
        $response = $this->service->playerSold($request, $division);

        return response()->json(
            ['status' => 'success',
                'data' => $response,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function updateSoldPlayer(Request $request, $division)
    {
        $response = $this->service->updateSoldPlayer($request, $division);

        return response()->json(
            ['status' => 'success',
                'data' => $response,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function deleteSoldPlayer(Request $request, $division)
    {
        $response = $this->service->deleteSoldPlayer($request, $division);

        return response()->json(
            ['status' => 'success',
                'data' => $response,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function getSoldPlayersOfTeam(Request $request, $division, $team)
    {
        $playersList = $this->service->getSoldPlayersOfTeam($request, $division, $team);

        return response()->json(
            ['status' => 'success',
                'data' => $playersList,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function getServerTime()
    {
        return response()->json(
            ['status' => 'success',
                'data' => ['timestamp' => Carbon::now()->timestamp],
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function getTeamPlayerCountForClub(Request $request, Division $division, $club, $team)
    {
        $response = $this->service->getTeamPlayerCountForClub($request, $division, $club, $team);

        return response()->json(
            ['status' => 'success',
                'data' => $response,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function endLonAuction(Request $request, Division $division)
    {
        $response = $this->service->endLonAuction($division);

        return $response;
    }

    public function isLonAuctionTeamsSquadFull(Division $division)
    {
        $response = $division->allOnlineAuctionTeamsSquadFull();

        return response()->json(
                        ['status' => 'success',
                            'data' => ['isClosed' => $response],
                        ],
                         JsonResponse::HTTP_OK
                     );
    }
}
