<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Team;
use App\Models\Player;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Services\ClubService;
use Illuminate\Http\JsonResponse;
use App\Services\AuctionService;
use App\Services\ValidateFormationService;
use App\Http\Controllers\Api\Controller as BaseController;

class LiveOfflineAuctionController extends BaseController
{
    /**
     * @var service
     */
    protected $service;

    /**
     * @var validateFormationService
     */
    protected $validateFormationService;

    protected $clubService;

    public function __construct(AuctionService $service, ValidateFormationService $validateFormationService, ClubService $clubService)
    {
        $this->service = $service;
        $this->clubService = $clubService;
        $this->validateFormationService = $validateFormationService;
    }

    public function getTeams(Division $division, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        $team = $request->user()->consumer->ownTeamDetails($division);

        if (! $request->user()->can('isChairmanOrManagerOrParentleague', [$division, $team]) || $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $divisionTeams = $this->service->getDivisionTeamsDetails($division);
        $isChairman = $request->user()->can('ownLeagues', $division);

        return response()->json(['status' => 'success', 'data' => $divisionTeams, 'isChairman' => $isChairman], JsonResponse::HTTP_OK);
    }

    public function getTeamDetails(Division $division, Team $team, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('isChairmanOrManagerAndOwnDivision', [$division, $team]) || $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPostions($team));
        $formatedAvailablePostions = collect($availablePostions)->map(function ($position) {
            return player_position_short($position);
        })->toArray();

        $players = $this->service->getTeamPlayersPositionWise($division, $team);
        $positions = $this->service->getPositions($division);

        $data['team'] = $this->service->getTeamDetails($division, $team);
        $data['teamClubsPlayer'] = $this->service->getTeamClubsPlayer($team);
        $data['maxClubPlayers'] = $division->getOptionValue('default_max_player_each_club');
        $data['mergeDefenders'] = $division->getOptionValue('merge_defenders');
        $data['defensiveMidfields'] = $division->getOptionValue('defensive_midfields');
        $data['bidIncrement'] = $division->getOptionValue('pre_season_auction_bid_increment');
        $data['availablePostions'] = $formatedAvailablePostions;
        $data['clubs'] = $this->service->getClubs();
        $data['clubs'] = $this->clubService->getPremierClubsShortCode();
        $data['positions'] = $positions;
        $data['players'] = $players;
        $data['pitch'] = config('fantasy.pitch_url');
        $data['isOwnTeam'] = auth()->user()->can('ownTeam', $team);
        $data['messages'] = __('messages.offline_auction');

        return response()->json( ['status' => 'success', 'data' => $data, ], JsonResponse::HTTP_OK );
    }

    public function getPlayers(Request $request, Division $division, Team $team)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('isChairmanOrManager', [$division, $team]) || $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data['players'] = $this->service->getPlayers($division, $team, $request->all());

        return response()->json( ['status' => 'success', 'data' => $data, ], JsonResponse::HTTP_OK );
    }

    public function create(Request $request, Division $division, Team $team)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('isChairmanOrManager', [$division, $team]) || $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'amount' => 'required|numeric',
            'player_id' => 'required|numeric',
            'club_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            
            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        $teamClubPlayers = $this->service->getTeamClubPlayers($team->id, $request['club_id']);
        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPostions($team));
        $playerPosition = $this->service->getplayerPosition($division, $request['club_id'], $request['player_id']);
        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');

        if (! check_number_is_divisible($bidIncrement, $data['amount'])) {

            return response()->json(['status' => 'error', 'message' => 'Bid must be a multiple of '.$bidIncrement.'m'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($team->team_budget < $data['amount']) {

            return response()->json(['status' => 'error', 'message' => 'Team budget is not enough'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($defaultSquadSize <= $team->teamPlayers->count()) {

            return response()->json(['status' => 'error', 'message' => 'Default squad size error'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($maxClubPlayer <= $teamClubPlayers) {

            return response()->json(['status' => 'error', 'message' => 'Club quota is full'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (! collect($availablePostions)->contains($playerPosition)) {

            return response()->json(['status' => 'error', 'message' => 'Invalid formation'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $playerInAnotherTeam = $this->service->checkAuctionPlayerInAnotherTeam($division, $request->get('player_id'));

        if ($playerInAnotherTeam > 0) {

            return response()->json(['status' => 'error', 'message' => 'Auction player already in other team'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! $this->service->create($division, $team, $data)) {

            return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
    }

    public function edit(Request $request, Division $division, Team $team)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('isChairmanOrManager', [$division,$team]) || $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'old_amount' => 'required|numeric',
            'amount' => 'required|numeric',
            'player_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $teamBudget = $team->team_budget + $request['old_amount'];

        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');

        if (! check_number_is_divisible($bidIncrement, $data['amount'])) {

            return response()->json(['status' => 'error', 'message' => 'Bid must be a multiple of '.$bidIncrement.'m'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($teamBudget < $data['amount']) {

            return response()->json(['status' => 'error', 'message' => 'Team budget is not enough'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! $this->service->edit($division, $team, $data)) {
        	
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
    }

    public function destroy(Division $division, Team $team, Player $player, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('isChairmanOrManager', [$division, $team]) || $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($this->service->destroy($division, $team, $player)) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.deleted.success')], JsonResponse::HTTP_OK);
            
        } else {

            return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return redirect()->back();
    }

    public function close(Division $division, Request $request)
    {
        if($division->isPostAuctionState()) {
            
            return response()->json(['status' => 'success', 'message' => 'Auction closed.', 'is_auction_closed' => true ], JsonResponse::HTTP_OK);
        }
        
        if (! $request->user()->can('liveOfflineAuctionChairman', $division)) {

            return response()->json(['status' => 'error', 'is_auction_closed' => $division->isPostAuctionState(), 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($this->service->allTeamSizeFull($division)) {

            if ($this->service->close($division)) {

                return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
            }

            return response()->json(['status' => 'error', 'message' => 'Please fill players in all team of Division'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function auctionPackPdfDownload(Division $division)
    {
        $auctionPackPdfDownload = $this->service->auctionPackPdfDownload($division);

        return response()->json( ['status' => 'success', 'data' => $auctionPackPdfDownload, ], JsonResponse::HTTP_OK );
    }
}
