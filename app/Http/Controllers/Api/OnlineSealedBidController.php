<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Team;
use App\Models\Player;
use App\Models\Division;
use App\Enums\YesNoEnum;
use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Models\OnlineSealedBid;
use App\Services\AuctionService;
use Illuminate\Validation\Rule;
use App\Services\PackageService;
use Illuminate\Http\JsonResponse;
use App\Services\AuctionCommanService;
use App\Services\AuctionRoundService;
use App\Services\OnlineSealedBidService;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Services\ValidateFormationService;
use App\Http\Resources\Division as DivisionResource;
use App\Http\Resources\AuctionRound as AuctionRoundResource;

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
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('sealBidAuction', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $round = $this->auctionRoundService->getRound($division);
        $endRound = $this->auctionRoundService->getEndRound($division);
        $teams = $this->service->getTeams($division, $round);
        $consumer = $request->user()->consumer;

        return response()->json([
            'teams' => $teams,
            'round' => $round ? new AuctionRoundResource($round) : [],
            'previousEndRound' => $endRound ? new AuctionRoundResource($endRound) : [],
            'previousEndRoundCount' => $endRound ? true : false,
            'currentDateTime' => now(),
            'ownLeague' => $request->user()->can('ownLeagues', $division),
            'auction_start' => $division->auction_date,
            'is_auction_start' => $division->auction_date && $division->auction_date <= now(),
            'auction_end' => $division->auction_closing_date,
            'is_auction_end' => $division->auction_closing_date && $division->auction_closing_date <= now(),
            'is_round_process' => $division->is_round_process,
            'manual_bid' => $division->getOptionValue('manual_bid') === YesNoEnum::YES ? true : false,
            'defaultSquadSize' => $division->getOptionValue('default_squad_size'),
            'consumer' => $consumer,
        ]);
    }

    public function getTeamsDetails(Division $division, Team $team)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! auth()->user()->can('sealBidAuction', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $round = $this->auctionRoundService->getActiveRound($division);
        $team = $this->service->getTeamDetails($division, $team, $round);
        $teamPlayers = $this->service->getTeamPlayersPositionWise($division, $team, $round, auth()->user());

        $positions = $this->auctionCommanService->getPositions($division);
        $clubs = [];
        $rounds = [];
        $teamClubsPlayer = [];
        $formatedAvailablePostions = [];
        $teams = [];
        $status = [];
        if (auth()->user()->can('isChairmanOrManager', [$division, $team])) {
            $clubs = $this->clubService->getPremierClubsShortCode();
            $rounds = $this->auctionRoundService->getEndRounds($division);
            $rounds = AuctionRoundResource::collection($rounds);
            $teamClubsPlayer = $this->service->getClubIdWithCount($team->id, $round);
            $availablePosition = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPositions($team, $round));
            $formatedAvailablePostions = collect($availablePosition)->map(function ($position) {
                return player_position_short($position);
            })->toArray();
            $teams = $division->divisionTeams()->approve()->get()->pluck('name', 'id');
            $status = OnlineSealedBidStatusEnum::toSelectArray();
        }

        return response()->json([
            'team' => $team,
            'teamPlayers' => $teamPlayers,
            'teams' => $teams,
            'round' => new AuctionRoundResource($round),
            'roundsFilter' => $rounds,
            'statusFilter' => $status,
            'clubsFilter' => $clubs,
            'positionsFilter' => $positions,
            'teamClubsPlayer' => $teamClubsPlayer,
            'availablePosition' => $formatedAvailablePostions,
            'isOwnTeam' => auth()->user()->can('ownTeam', $team),
            'bidIncrement' => $division->getOptionValue('pre_season_auction_bid_increment'),
            'mergeDefenders' => $division->getOptionValue('merge_defenders'),
            'maxClubPlayers' => $division->getOptionValue('default_max_player_each_club'),
            'defensiveMidfields' => $division->getOptionValue('defensive_midfields'),
            'pitch' => config('fantasy.pitch_url'),
            'messages' => __('messages.online_sealed_bid')
        ]);
    }

    public function getPlayers(Division $division, Team $team, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('sealBidAuctionChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $round = $this->auctionRoundService->getActiveRound($division);

        $isMobile = true;

        $players = $this->service->getPlayers($division, $team, $request->all(), $round, $isMobile);

        return response()->json([
            'data' => $players,
        ]);
    }

    public function getBids(Division $division, Team $team, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('sealBidAuctionChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();
        $round = $this->auctionRoundService->getActiveRound($division);
        $bids = $this->service->getBids($division, $team, $round, $data);

        return response()->json([
            'data' => $bids,
        ]);
    }

    public function store(Division $division, Team $team, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('sealBidAuctionChairman', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $round = $this->auctionRoundService->getActiveRound($division);

        $data = $request->all();

        $validator = Validator::make($data, [
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
            
            return $this->responseReturn($validator);
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

        if (! check_number_is_divisible($bidIncrement, $data['amount'])) {

            return response()->json(['status' => 'error', 'message' => 'Bid must be a multiple of '.$bidIncrement.'m'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($budget < $data['amount']) {

            return response()->json(['status' => 'error', 'message' => __('sealbid.auction.budget')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($defaultSquadSize <= ($sealBidCount + $team->teamPlayers->count())) {

            return response()->json(['status' => 'error', 'message' => __('sealbid.auction.squad_size')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($maxClubPlayer <= $teamClubPlayers) {

            return response()->json(['status' => 'error', 'message' => __('sealbid.auction.club_quota')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (! collect($availablePostions)->contains($playerPosition)) {

            return response()->json(['status' => 'error', 'message' => __('sealbid.auction.formation')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $onlineSealedBid = $this->service->create($division, $team, $round, $data);

        if ($onlineSealedBid) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function responseReturn($validator)
    {
        return response()->json(['status' => 'error', 'message' => $validator->messages()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function update(Division $division, Team $team, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('sealBidAuctionChairman', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $onlineSealedBid = OnlineSealedBid::find($request->get('bid_id'));
        $onlineSealedBidId = $onlineSealedBid ? $onlineSealedBid->id : 0;
        $round = $this->auctionRoundService->getActiveRound($division);

        $validator = Validator::make($data, [
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
            return $this->responseReturn($validator);
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

        $validator->after(function ($validator) use ($budget, $team, $defaultSquadSize, $maxClubPlayer, $teamClubPlayers, $availablePostions, $playerPosition, $bidIncrement, $data) {
            if (! check_number_is_divisible($bidIncrement, $data['amount'])) {
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
            return $this->responseReturn($validator);
        }

        $onlineSealedBid = $this->service->update($onlineSealedBid, $data);

        if ($onlineSealedBid) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function destroy(Division $division, OnlineSealedBid $sealBid)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! auth()->user()->can('sealBidAuctionChairman', [$division, $sealBid->team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if (! $sealBid->status) {
            if ($sealBid->delete()) {
                return response()->json(['status' => 'success', 'message' => __('messages.data.deleted.success')], JsonResponse::HTTP_OK);
            }
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.deleted.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function processManualStart(Division $division)
    {
        if (! auth()->user()->can('sealBidAuctionProcess', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        $round = $this->auctionRoundService->getEndRound($division);
        $result = $this->service->sealBidProcessManual($division, $round);
        $division = $division->fresh();

        if ($result) {

            $messsage = $division->isPostAuctionState() ? __('messages.divisions.auction_close') : __('messages.divisions.auction_process');

            return response()->json(['status' => 'success', 'is_auction_closed' => $division->isPostAuctionState(), 'message' => $messsage ], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
