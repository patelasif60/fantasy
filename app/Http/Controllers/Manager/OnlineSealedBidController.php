<?php

namespace App\Http\Controllers\Manager;

use App\Enums\EventsEnum;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\OnlineSealedBid;
use App\Models\Player;
use App\Models\Team;
use App\Services\AuctionCommanService;
use App\Services\AuctionRoundService;
use App\Services\AuctionService;
use App\Services\ClubService;
use App\Services\OnlineSealedBidService;
use App\Services\PackageService;
use App\Services\ValidateFormationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use JavaScript;
use Validator;

class OnlineSealedBidController extends Controller
{
    /**
     * @var OnlineSealedBidService
     */
    protected $service;

    /**
     * @var AuctionService
     */
    protected $auctionService;

    /**
     * @var PackageService
     */
    protected $packageService;

    /**
     * @var ValidateFormationService
     */
    protected $validateFormationService;

    /**
     * @var ClubService
     */
    protected $clubService;

    /**
     * @var AuctionRoundService
     */
    protected $auctionRoundService;

    /**
     * @var AuctionCommanService
     */
    protected $auctionCommanService;

    public function __construct(OnlineSealedBidService $service, AuctionService $auctionService, PackageService $packageService, ValidateFormationService $validateFormationService, ClubService $clubService, AuctionRoundService $auctionRoundService, AuctionCommanService $auctionCommanService)
    {
        $this->service = $service;
        $this->clubService = $clubService;
        $this->auctionService = $auctionService;
        $this->packageService = $packageService;
        $this->auctionRoundService = $auctionRoundService;
        $this->auctionCommanService = $auctionCommanService;
        $this->validateFormationService = $validateFormationService;
    }

    public function index(Division $division, Request $request)
    {
        if ($division->isPostAuctionState()) {
            return redirect()->route('manage.division.info', ['division' => $division]);
        }

        $this->authorize('sealBidAuction', $division);

        $consumer = $request->user()->consumer;

        $round = $this->auctionRoundService->getRound($division);
        $endRound = $this->auctionRoundService->getEndRound($division);

        $nextRoundCount = 0;
        if ($endRound) {
            $nextRoundCount = $this->auctionRoundService->getNextRoundCount($division);
        }

        JavaScript::put([
            'divisionId' => $division->id,
            'consumer' => $consumer,
            'defaultSquadSize' => $division->getOptionValue('default_squad_size'),
        ]);

        return view('manager.divisions.online_sealed_bid.index', compact('division', 'endRound', 'round', 'nextRoundCount'));
    }

    public function getTeamsDataJson(Division $division, Request $request)
    {
        $this->authorize('sealBidAuction', $division);

        $round = $this->auctionRoundService->getActiveRound($division);
        $dataTabs = [];

        if ($round) {
            $dataTabs = $this->service->getTeams($division, $round);
        }

        return response()->json([
            'data' => $dataTabs,
        ]);
    }

    public function playerInitialCount($teamPlayers)
    {
        $nm = collect($teamPlayers)->flatten()->pluck('player_last_name');
        $count = \App\Models\Player::whereIn('last_name', $nm)
        ->select('last_name', \DB::raw('count(*) as total'))
        ->groupBy('last_name')
        ->get()->pluck('total', 'last_name');

        return $count;
    }

    public function getTeamsDetails(Division $division, Team $team, Request $request)
    {
        $this->authorize('sealBidAuction', [$division, $team]);

        $round = $this->auctionRoundService->getActiveRound($division);

        if (! $round) {
            return redirect()->route('manage.auction.online.sealed.bid.index', ['division' => $division]);
        }

        $isGk = player_position_short(AllPositionEnum::GOALKEEPER);
        $teamPlayers = $this->service->getTeamPlayersPositionWise($division, $team, $round, $request->user());
        $playerInitialCount = $this->playerInitialCount($teamPlayers);
        $data['tab'] = $request->has('tab') && $request->get('tab') ? $request->get('tab') : '';
        $data['pos'] = $request->has('pos') && $request->get('pos') ? $request->get('pos') : '';
        $team = $this->service->getTeamDetails($division, $team, $round);

        $bidIncrementDecimalPlace = get_decimal_part_of_a_number(floatval($division->getOptionValue('pre_season_auction_bid_increment')));

        if ($request->user()->can('ownTeam', $team)) {
            $positions = $this->auctionCommanService->getPositions($division);
            $clubs = $this->clubService->getPremierClubsShortCode();
            $auctionRounds = $this->auctionRoundService->getEndRounds($division);
            $statusEnums = OnlineSealedBidStatusEnum::toSelectArray();
            $teams = $division->divisionTeams()->approve()->get()->pluck('name', 'id');
            $teamClubsPlayer = $this->service->getClubIdWithCount($team->id, $round);
            $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPositions($team, $round));
            // dd($availablePostions);
            $formatedAvailablePostions = collect($availablePostions)->map(function ($position) {
                return player_position_short($position);
            })->toArray();

            $mergeDefenders = $division->getOptionValue('merge_defenders');
            $defensiveMidfields = $division->getOptionValue('defensive_midfields');
            $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');

            JavaScript::put([
                'maxClubPlayers' => $division->getOptionValue('default_max_player_each_club'),
                'teamClubsPlayer' => $teamClubsPlayer,
                'divisionId' => $division->id,
                'team' => $team,
                'teamBudget' => $team->budget,
                'availablePostions' => $formatedAvailablePostions,
                'mergeDefenders' => $mergeDefenders,
                'defensiveMidfields' => $defensiveMidfields,
                'assetUrl' => asset('assets/frontend'),
                'statusEnums' => $statusEnums,
                'allPositionEnum' => AllPositionEnum::toArray(),
                'events' => EventsEnum::toArray(),
                'isOwnTeam' => auth()->user()->can('ownTeam', $team),
                'isGk' => $isGk,
                'bidIncrement' => $bidIncrement,
            ]);
        }

        return view('manager.divisions.online_sealed_bid.team', compact('teamPlayers', 'team', 'division', 'positions', 'clubs', 'auctionRounds', 'statusEnums', 'teams', 'data', 'isGk', 'bidIncrement', 'playerInitialCount', 'bidIncrementDecimalPlace'));
    }

    public function getTabsData(Division $division, Team $team, $tabs, Request $request)
    {
        $this->authorize('sealBidAuctionChairmanOrManager', [$division, $team]);

        $dataTabs = [];
        $round = $this->auctionRoundService->getActiveRound($division);

        if ($tabs == 'players') {
            $dataTabs = $this->service->getPlayers($division, $team, $request->all(), $round);
        }

        if ($tabs == 'bids') {
            $dataTabs = $this->service->getBids($division, $team, $round, $request->all());
        }

        return response()->json([
            'data' => $dataTabs,
        ]);
    }

    public function store(Division $division, Team $team, Request $request)
    {
        $this->authorize('sealBidAuctionChairman', [$division, $team]);

        $round = $this->auctionRoundService->getActiveRound($division);

        $validator = Validator::make($request->all(), [
            'player_id' => [
                'required',
                'numeric',
                Rule::unique('online_sealed_bids')->where(function ($query) use ($round, $team) {
                    return $query->where('team_id', $team->id)
                        ->where('auction_rounds_id', $round->id)
                        ->whereNull('status');
                }),
            ],
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $player = Player::find($request->get('player_id'));
        $budget = $this->service->getBudget($team, $round);
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');
        $playerClubId = $player->playerContracts ? $player->playerContracts->last()->club_id : 0;
        $teamClubPlayers = $this->auctionService->getTeamClubPlayers($team->id, $playerClubId);
        $playerPosition = $this->auctionService->getplayerPosition($division, $playerClubId, $request->get('player_id'));
        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->auctionService->getTeamPlayerPostions($team));

        $sealBidCount = $round->onlineSealedBids()->where('team_id',$team->id)->count();

        $validator->after(function ($validator) use ($budget, $team, $defaultSquadSize, $maxClubPlayer, $teamClubPlayers, $availablePostions, $playerPosition, $bidIncrement, $sealBidCount) {
            if (! check_number_is_divisible($bidIncrement, request()->get('amount'))) {
                $validator->errors()->add('amount', 'Bid must be a multiple of '.$bidIncrement.'m');
            }
            if ($budget < request()->get('amount')) {
                $validator->errors()->add('amount', 'Team budget is not enough');
            }
            if ($defaultSquadSize <= ($sealBidCount + $team->teamPlayers->count())) {
                $validator->errors()->add('amount', 'Default squad size error');
            }
            if ($maxClubPlayer <= $teamClubPlayers) {
                $validator->errors()->add('amount', 'Club quota is full');
            }
            if (! collect($availablePostions)->contains($playerPosition)) {
                $validator->errors()->add('amount', 'Invalid formation');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $onlineSealedBid = $this->service->create($division, $team, $round, $request->all());

        if ($onlineSealedBid) {
            //flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->back();
    }

    public function update(Division $division, Team $team, Request $request)
    {
        $this->authorize('sealBidAuctionChairman', [$division, $team]);

        $onlineSealedBid = OnlineSealedBid::find($request->get('bid_id'));
        $onlineSealedBidId = $onlineSealedBid ? $onlineSealedBid->id : 0;
        $round = $this->auctionRoundService->getActiveRound($division);

        $validator = Validator::make($request->all(), [
            'bid_id' => 'required|numeric',
            'player_id' => [
                'required',
                'numeric',
                Rule::unique('online_sealed_bids')->where(function ($query) use ($round, $team, $onlineSealedBidId) {
                    return $query->where('team_id', $team->id)
                        ->where('auction_rounds_id', $round->id)
                        ->whereNull('status');
                })->ignore($onlineSealedBidId),
            ],
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $player = Player::find($request->get('player_id'));
        $budget = $this->service->getBudget($team, $round) + $onlineSealedBid->amount;
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');
        $playerClubId = $player->playerContract->club_id;
        $teamClubPlayers = $this->auctionService->getTeamClubPlayers($team->id, $playerClubId);
        $playerPosition = $this->auctionService->getplayerPosition($division, $playerClubId, $request->get('player_id'));
        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->auctionService->getTeamPlayerPostions($team));

        $validator->after(function ($validator) use ($budget, $team, $defaultSquadSize, $maxClubPlayer, $teamClubPlayers, $availablePostions, $playerPosition, $bidIncrement) {
            if (! check_number_is_divisible($bidIncrement, request()->get('amount'))) {
                $validator->errors()->add('amount', 'Bid must be a multiple of '.$bidIncrement.'m');
            }
            if ($budget < request()->get('amount')) {
                $validator->errors()->add('amount', 'Team budget is not enough');
            }
            if ($defaultSquadSize <= $team->teamPlayers->count()) {
                $validator->errors()->add('amount', 'Default squad size error');
            }
            if ($maxClubPlayer <= $teamClubPlayers) {
                $validator->errors()->add('amount', 'Club quota is full');
            }
            if (! collect($availablePostions)->contains($playerPosition)) {
                $validator->errors()->add('amount', 'Invalid formation');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $onlineSealedBid = $this->service->update($onlineSealedBid, $request->all());

        if ($onlineSealedBid) {
            //flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->back();
    }

    public function destroy(Division $division, OnlineSealedBid $sealBid)
    {
        $this->authorize('sealBidAuctionChairman', [$division, $sealBid->team]);

        if (! $sealBid->status) {
            if ($sealBid->delete()) {
                //flash(__('messages.data.deleted.success'))->success();
            } else {
                flash(__('messages.data.deleted.error'))->error();
            }
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->back();
    }

    public function processManualStart(Division $division)
    {
        $this->authorize('sealBidAuctionProcess', $division);

        if ($division->isPostAuctionState()) {

            return redirect()->route('manage.division.info', ['division' => $division]);
        }

        $result = null;
        if (! $division->is_round_process) {
            $round = $this->auctionRoundService->getEndRound($division);
            $result = $this->service->sealBidProcessManual($division, $round);
            $division = $division->fresh();
        }

        if ($result) {

            $messsage = $division->isPostAuctionState() ? __('messages.divisions.auction_close') : __('messages.divisions.auction_process');

            flash($messsage)->success();

            if ($division->isPostAuctionState()) {

                return redirect()->route('manage.division.info', ['division' => $division]);
            }

        } else {
            
            flash('Something went wrong.')->error();
        }

        return redirect()->back();
    }
}
