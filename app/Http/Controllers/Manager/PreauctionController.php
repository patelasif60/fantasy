<?php

namespace App\Http\Controllers\Manager;

use App\Enums\EventsEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\DivisionService;
use App\Services\InviteService;
use Illuminate\Http\Request;

class PreauctionController extends Controller
{
    protected $inviteService;
    protected $divisionService;

    public function __construct(DivisionService $divisionService, InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
        $this->divisionService = $divisionService;
    }

    public function showRules(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManager', [$division, $team]);

        return view(
            'manager.divisions.preauction.league_rules',
            $this->divisionService->getRulesData($division)
        );
    }

    public function showInvite(Request $request, Division $division)
    {
        $this->authorize('accessPreAuctionState', [$division, true]);
        $invitation = $this->inviteService->invitation($division);
        $code = $invitation->code;

        return view('manager.divisions.preauction.invites', compact('division', 'code'));
    }

    public function scoringSystem(Request $request, Division $division)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $yesNo = YesNoEnum::toSelectArray();
        $events = EventsEnum::toSelectArray();
        $points = $this->divisionService->getPointsData($division);

        return view('manager.divisions.preauction.scoring', compact('division', 'events', 'points', 'yesNo'));
    }

    public function positionPoints(Request $request, Division $division, $event)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);
        
        $this->authorize('isChairmanOrManager', [$division, $team]);
        
        $positions = array_change_key_case(array_map('ucwords', TeamPointsPositionEnum::toArray()), CASE_LOWER);

        $points = $this->divisionService->getCustomDivisionPoints($division, $event);

        return view('manager.divisions.preauction.points', compact('division', 'positions', 'points', 'event'));
    }
}
