<?php

namespace App\Http\Controllers\Manager;

use App\DataTables\Preauction\DivisionTeamsDataTable;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionTeam;
use App\Models\Team;
use App\Services\AuctionService;
use App\Services\DivisionService;
use App\Services\LeaguePaymentService;
use App\Services\TeamService;
use Illuminate\Http\Request;

class LeaguePaymentsController extends Controller
{
    /**
     * @var LeaguePaymentService
     */
    protected $leaguePaymentService;
    protected $teamService;
    protected $divisionService;

    public function __construct(LeaguePaymentService $leaguePaymentService, TeamService $teamService, AuctionService $auctionService, DivisionService $divisionService)
    {
        $this->leaguePaymentService = $leaguePaymentService;
        $this->teamService = $teamService;
        $this->auctionService = $auctionService;
        $this->divisionService = $divisionService;
    }

    public function index(\Illuminate\Http\Request $request, Division $division, $type)
    {
        $teamApprovals = $this->divisionService->teamApprovals($division);
        $price = $division->getPrice();
        $allTeams = $this->leaguePaymentService->getTeamsSortByUser($request->user(), $division);
        $user = $request->user();

        if ($division->package->private_league == YesNoEnum::NO) {
            $checkPaymentForSocialLeague = $this->leaguePaymentService->checkPaymentForSocialLeague($request->user()->consumer->id, $division);

            $via = 'social';
            $teamId = $checkPaymentForSocialLeague->team_id;
            $prize = $division->getPrice();
            $team = team::find($checkPaymentForSocialLeague->team_id);
            if ($checkPaymentForSocialLeague->payment_id > 0) {
                if ($division->isInAuctionState()) {
                    return redirect(route('manage.auction.payment.index', ['division' => $division, 'type'=>'auction']));
                } elseif ($division->isPreAuctionState()) {
                    return view('manager.divisions.payment.index', compact('division', 'price', 'allTeams', 'user', 'teamApprovals'));
                } else {
                    return redirect(route('manage.team.lineup', ['division' => $division, 'team' => $team]));
                }
            } else {
                return  view(
                'manager.divisions.payment.checkout',
                 $this->leaguePaymentService->getCheckoutData(['teams'=>[$teamId => $prize], '_token'=>csrf_token()], $division, $request->user()),
                 compact('team', 'via', 'teamId', 'prize')
                );
            }
        }

        return view('manager.divisions.payment.index', compact('division', 'price', 'allTeams', 'user', 'teamApprovals'));
    }

    public function auctionIndex(Request $request, Division $division, $type)
    {
        return view(
            'manager.divisions.preauction.auction',
            $this->auctionService->getPreAuctionDetails($division)
        );
    }

    public function checkout(Request $request, Division $division, Team $team)
    {
        $user = $request->user();
        $via = '';
        if ($request->get('via') == 'social') {
            $via = $request->get('via');
        }
        $teamId = $request['selectedTeam'];
        $prize = $request['selectPrize'];

        return view(
            'manager.divisions.payment.checkout',
            $this->leaguePaymentService->getCheckoutData($request->all(), $division, $user),
            compact('team', 'via', 'teamId', 'prize')
        );
    }

    public function payment(Request $request, Division $division, Team $team)
    {
        $user = $request->user();
        $payment = $this->leaguePaymentService->makePayment($request->all(), $division, $user);
        if ($request->get('via') == 'social') {
            $team = ($payment['teams'][count($payment['teams']) - 2])->team;

            return redirect(route('manage.division.app.info', compact('division', 'team')));
        }

        $via = $request->get('via');

        return view('manager.divisions.payment.status', compact('division', 'payment', 'team', 'via'));
    }

    public function select(Request $request, Division $division)
    {
        if ($division->package->private_league == YesNoEnum::NO) {
            $checkPaymentForSocialLeague = $this->leaguePaymentService->checkPaymentForSocialLeague($request->user()->consumer->id, $division);

            $via = 'social';
            $teamId = $checkPaymentForSocialLeague->team_id;
            $prize = $division->getPrice();
            $team = team::find($checkPaymentForSocialLeague->team_id);
            if ($checkPaymentForSocialLeague->payment_id > 0) {
                if ($division->isInAuctionState()) {
                    return redirect(route('manage.auction.payment.index', ['division' => $division, 'type'=>'auction']));
                } elseif ($division->isPreAuctionState()) {
                    return redirect(route('manage.division.teams.index'));
                } else {
                    return redirect(route('manage.team.lineup', ['division' => $division, 'team' => $team]));
                }
            } else {
                return  view(
                'manager.divisions.payment.checkout',
                 $this->leaguePaymentService->getCheckoutData(['teams'=>[$teamId => $prize], '_token'=>csrf_token()], $division, $request->user()),
                 compact('team', 'via', 'teamId', 'prize')
                );
            }
        }

        $price = $prize = $division->getPrice();
        $teamId = $request['teamId'];
        $isFreeCount = DivisionTeam::where('team_id', $teamId)->where('is_free', 1)->count();
        if ($isFreeCount > 0) {
            $prize = $division->getPrize();
        }

        $unpaidTeams = $this->leaguePaymentService->getTeamsSortByUser($request->user(), $division);

        $via = '';

        if ($request->get('via') == 'social') {
            $via = $request->get('via');
        }
        $user = $request->user();

        return view(
            'manager.divisions.payment.team_selection',
            compact('division', 'price', 'unpaidTeams', 'via', 'user', 'teamId', 'prize')
        );
    }

    public function teams(Division $division, DivisionTeamsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}
