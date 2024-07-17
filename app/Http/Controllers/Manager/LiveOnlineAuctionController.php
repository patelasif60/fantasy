<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\LiveOnlineAuctionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LiveOnlineAuctionController extends Controller
{
    protected $service;

    public function __construct(LiveOnlineAuctionService $service)
    {
        $this->service = $service;
    }

    public function index(Division $division)
    {
        $this->authorize('liveOnlineAuctionChairmanOrManager', $division);

        return redirect()->route('manage.live.online.auction.start', ['division' => $division]);
    }

    public function start(Request $request, Division $division)
    {
        $this->authorize('liveOnlineAuctionChairmanOrManager', $division);

        $isMobile = false;

        $data = $this->service->getTeamManagers($request, $division, $isMobile);

        $division = $data['division'];
        $teamManagers = $data['teamManagers'];
        $positions = $data['positions'];
        $clubs = $data['clubs'];
        $players = $data['players'];
        $maxClubPlayer = $data['maxClubPlayer'];
        $defaultSquadSize = $data['defaultSquadSize'];

        return view('manager.live_online_auction.start', compact('division', 'teamManagers', 'positions', 'clubs', 'players', 'maxClubPlayer', 'defaultSquadSize'));
    }

    public function searchPlayers(Request $request, Division $division)
    {
        $players = $this->service->searchPlayers($request, $division);

        return $players;
    }

    public function getPlayers(Request $request, Division $division)
    {
        $players = $this->service->getPlayers($request, $division);

        return response()->json([
            'data' => $players,
        ]);
    }

    public function playerSold(Request $request, $division)
    {
        $response = $this->service->playerSold($request, $division);

        return response()->json($response, 200);
    }

    public function updateSoldPlayer(Request $request, $division)
    {
        $response = $this->service->updateSoldPlayer($request, $division);

        return response()->json($response, 200);
    }

    public function deleteSoldPlayer(Request $request, $division)
    {
        $response = $this->service->deleteSoldPlayer($request, $division);

        return response()->json($response, 200);
    }

    public function getSoldPlayersOfTeam(Request $request, $division, $team)
    {
        $playersList = $this->service->getSoldPlayersOfTeam($request, $division, $team);

        return response()->json($playersList);
    }

    public function getServerTime()
    {
        return response()->json([
            'data' => Carbon::now()->timestamp,
        ]);
    }

    public function getTeamPlayerCountForClub(Request $request, Division $division, $club, $team)
    {
        $response = $this->service->getTeamPlayerCountForClub($request, $division, $club, $team);

        return $response;
    }

    public function endLonAuction(Request $request, Division $division)
    {
        $response = $this->service->endLonAuction($division);

        return $response;
    }

    public function isLonAuctionTeamsSquadFull(Division $division)
    {
        $response = $division->allOnlineAuctionTeamsSquadFull();

        return ['status' => $response];
    }
}
