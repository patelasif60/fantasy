<?php

namespace App\Http\Controllers\Manager;

use JavaScript;
use Validator;
use App\Models\Team;
use App\Models\Player;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Services\AuctionService;
use App\Services\PackageService;
use App\Http\Controllers\Controller;
use App\Enums\TeamPointsPositionEnum;
use App\Services\ValidateFormationService;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class LiveOfflineAuctionController extends Controller
{
    /**
     * @var service
     */
    protected $service;

    /**
     * @var validateFormationService
     */
    protected $validateFormationService;

    /**
     * @var packageService
     */
    protected $packageService;

    public function __construct(AuctionService $service, ValidateFormationService $validateFormationService, PackageService $packageService)
    {
        $this->service = $service;
        $this->validateFormationService = $validateFormationService;
        $this->packageService = $packageService;
    }

    public function index(Division $division)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        $divisionTeams = $this->service->getDivisionTeamsDetails($division);
        $teamsSizeFlag = $this->service->allTeamSizeFull($division);

        JavaScript::put([
            'ownLeague' => auth()->user()->consumer->ownLeagues($division),
            'ownTeam' => auth()->user()->consumer->ownTeamDetails($division),
            'coChairmanOwnLeagues' => auth()->user()->consumer->isCoChairmanOfLeague($division),
        ]);

        $auctionPackPdfDownload = $this->service->auctionPackPdfDownload($division);

        return view('manager.live_offline_auction.index', compact('division', 'teamsSizeFlag', 'auctionPackPdfDownload'));
    }

    public function getTeams(Division $division)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);
        
        $divisionTeams = $this->service->getDivisionTeamsDetails($division);

        return response()->json([
            'data' => $divisionTeams,
        ]);
    }

    public function getTeamDetails(Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManagerAndOwnDivision', [$division, $team]);

        $teamPlayers = $this->service->getTeamPlayersPositionWise($division, $team);
        $clubs = $this->service->getClubs();
        $positions = $this->service->getPositions($division);
        $totalTeamPlayers = $team->teamPlayers->count();

        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPostions($team));
        $formatedAvailablePostions = collect($availablePostions)->map(function ($position) {
            return player_position_short($position);
        })->toArray();

        JavaScript::put([
            'defaultSquadSize' => $division->getOptionValue('default_squad_size'),
            'teamBudget' => $team->team_budget,
            'team' => $team,
            'teamClubsPlayer' => $this->service->getTeamClubsPlayer($team),
            'maxClubPlayers' => $division->getOptionValue('default_max_player_each_club'),
            'division' => $division,
            'totalTeamPlayers' => $totalTeamPlayers,
            'mergeDefenders' => $division->getOptionValue('merge_defenders'),
            'defensiveMidfields' => $division->getOptionValue('defensive_midfields'),
            'availablePostions' => $formatedAvailablePostions,
            'assetUrl' => asset('assets/frontend'),
            'playerPositions' => TeamPointsPositionEnum::toSelectArray(),
            'allPositionEnum' => ALLPositionEnum::toArray(),
            'bidIncrement' => $division->getOptionValue('pre_season_auction_bid_increment'),
        ]);

        return view('manager.live_offline_auction.team', compact('division', 'team', 'teamPlayers', 'clubs', 'positions', 'totalTeamPlayers', 'division'));
    }

    public function getPlayers(Request $request, Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $players = $this->service->getPlayers($division, $team, $request->all());

        return response()->json([
            'data' => $players,
        ]);
    }

    public function create(Request $request, Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'player_id' => 'required|numeric',
            'club_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            flash(__('Invalid request'))->error();

            return redirect()->back();
        }

        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');
        $teamClubPlayers = $this->service->getTeamClubPlayers($team->id, $request['club_id']);
        $playerPosition = $this->service->getplayerPosition($division, $request['club_id'], $request['player_id']);

        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPostions($team));

        $amount = $request->get('amount');
        if (! check_number_is_divisible($bidIncrement, $amount)) {
            flash('Bid must be a multiple of '.$bidIncrement.'m')->error();

            return redirect()->back();
        }

        if ($team->team_budget < $amount) {
            flash('Team budget is not enough')->error();

            return redirect()->back();
        }
        if ($defaultSquadSize <= $team->teamPlayers->count()) {
            flash('Default squad size error')->error();

            return redirect()->back();
        }
        if ($maxClubPlayer <= $teamClubPlayers) {
            flash('Club quota is full')->error();

            return redirect()->back();
        }
        if (! collect($availablePostions)->contains($playerPosition)) {
            flash('Invalid formation')->error();

            return redirect()->back();
        }

        $playerInAnotherTeam = $this->service->checkAuctionPlayerInAnotherTeam($division, $request->get('player_id'));

        if ($playerInAnotherTeam > 0) {
            flash('Auction player already in other team')->error();

            return redirect()->back();
        }

        if (! $this->service->create($division, $team, $request->all())) {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }

        flash(__('messages.data.saved.success'))->success();

        return redirect()->back();
    }

    public function edit(Request $request, Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $validator = Validator::make($request->all(), [
            'old_amount' => 'required|numeric',
            'amount' => 'required|numeric',
            'player_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            flash(__('Invalid request'))->error();

            return redirect()->back();
        }

        $teamBudget = $team->team_budget + $request['old_amount'];

        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');
        $amount = $request->get('amount');

        if (! check_number_is_divisible($bidIncrement, $amount)) {
            flash('Bid must be a multiple of '.$bidIncrement.'m')->error();

            return redirect()->back();
        }

        if ($teamBudget < $amount) {
            flash('Team budget is not enough')->error();

            return redirect()->back();
        }
        if (! $this->service->edit($division, $team, $request->all())) {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }

        flash(__('messages.data.saved.success'))->success();

        return redirect()->back();
    }

    public function destroy(Division $division, Team $team, Player $player)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        if ($this->service->destroy($division, $team, $player)) {

            flash(__('messages.data.deleted.success'))->success();

        } else {

            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->back();
    }

    public function close(Division $division)
    {
        $this->authorize('liveOfflineAuctionChairman', $division);

        if ($this->service->allTeamSizeFull($division)) {

            if ($this->service->close($division)) {

                flash(__('messages.data.saved.success'))->success();

                return redirect()->route('manage.division.info', ['division' => $division]);
            }
        }

        flash(__('messages.data.saved.error'))->error();

        return redirect()->back();
    }
}
