<?php

namespace App\Http\Controllers\Api;

use App\Enums\EventsEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\AuctionService;
use App\Services\DivisionService;
use App\Services\InviteService;
use App\Services\LeaguePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PreauctionController extends Controller
{
    protected $inviteService;
    protected $divisionService;

    public function __construct(DivisionService $divisionService, InviteService $inviteService, AuctionService $auctionService, LeaguePaymentService $leaguePaymentService)
    {
        $this->inviteService = $inviteService;
        $this->divisionService = $divisionService;
        $this->auctionService = $auctionService;
        $this->leaguePaymentService = $leaguePaymentService;
    }

    public function teamList(Request $request, Division $division)
    {
        $price = $division->getPrice();

        $teams = $this->leaguePaymentService->getTeamsSortByUser($request->user(), $division);

        $teams->each(function ($item, $key) use ($price) {
            $item->is_paid = false;
            if ($price == 0) {
                $item->is_paid = true;
            } else {
                $item->is_paid = ($item->payment_id) ? true : false;
            }
            $item->team_crest = asset('assets/frontend/img/default/square/default-thumb-100.png');
            if ($item->team->getCrestImageThumb()) {
                $item->team_crest = $item->team->getCrestImageThumb();
            }
            unset($item->division);
        });

        return response()->json([
            'data' => [
                'price' => $price,
                'paid_teams_count' => $division->paidTeamsCount(),
                'total_teams_count' => count($teams),
                'teams' => $teams,
                'division' => $division,
            ],
        ]);
    }

    public function showRules(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if ($request->user()->cannot('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json([
            'data' => $this->divisionService->getRulesData($division),
        ]);
    }

    public function scoringSystem(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if ($request->user()->cannot('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $events = EventsEnum::toSelectArray();

        $goalkeeperSaveX5 = EventsEnum::GOALKEEPER_SAVE_X5;
        $goalkeeperSaveX5Replace = 'Goalkeeper Save';

        return response()->json([
            'data' => [
                'events' => $events,
                'same_point_events' => $this->divisionService->getPointsData($division),
                'points_data'  => $this->divisionService->getCustomDivisionPoints($division),
                'goalkeeperSaveX5' => $goalkeeperSaveX5,
                'goalkeeperSaveX5Replace' => $goalkeeperSaveX5Replace,
                'message' => 'Did you know... your chairman can change your scoring system?',
            ],
        ]);
    }

    public function positionPoints(Request $request, Division $division, $event)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        if ($request->user()->cannot('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $title = ucwords(str_replace('_',' ', $event));

        return response()->json([
            'data' => [
                'title' => $title,
                'event' => $event,
                'positions' => array_change_key_case(array_map('ucwords', TeamPointsPositionEnum::toArray()), CASE_LOWER),
                'points' => $this->divisionService->getCustomDivisionPoints($division, $event),
            ],
        ]);
    }

    public function auctionIndex(Request $request, Division $division)
    {
        if ($request->user()->cannot('accessPreAuctionState', [$division, true])) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json([
            'data' => $this->auctionService->getPreAuctionDetails($division),
        ]);
    }

    public function showInvite(Request $request, Division $division)
    {
        if ($request->user()->cannot('accessPreAuctionState', [$division, true])) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $invitation = $this->inviteService->invitation($division);
        $code = $invitation->code;
        $url = route('manager.division.join.a.league', ['code' => $code]);

        return response()->json([
            'data' => [
                'code' => $code,
                'url'  => $url,
                'division' => $division,
            ],
        ]);
    }
}
