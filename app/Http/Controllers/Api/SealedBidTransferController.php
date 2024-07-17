<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Team;
use App\Models\Division;
use Illuminate\Support\Arr;
use App\Enums\MoneyBackEnum;
use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Models\SealedBidTransfer;
use Illuminate\Http\JsonResponse;
use App\Enums\SealedBidDeadLinesEnum;
use App\Services\TransferRoundService;
use App\Services\AuctionCommanService;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Enums\ManuallyProcessStatusEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Services\SealedBidTransferService;
use App\Services\OnlineSealedBidTransferService;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Http\Resources\TransferRound as TransferRoundResource;

class SealedBidTransferController extends Controller
{
    /**
     * @var SealedBidTransferService
     */
    protected $service;

    protected $clubService;

    /**
     * @var TransferRoundService
     */
    protected $transferRoundService;

    /**
     * @var AuctionCommanService
     */
    protected $auctionCommanService;

    /**
     * @var OnlineSealedBidTransferService
     */
    protected $onlineSealedBidTransferService;

    public function __construct(SealedBidTransferService $service, TransferRoundService $transferRoundService, AuctionCommanService $auctionCommanService, ClubService $clubService, OnlineSealedBidTransferService $onlineSealedBidTransferService)
    {
        $this->service = $service;
        $this->clubService = $clubService;
        $this->transferRoundService = $transferRoundService;
        $this->auctionCommanService = $auctionCommanService;
        $this->onlineSealedBidTransferService = $onlineSealedBidTransferService;
    }

    public function getTeamBids(Division $division, Team $team, Request $request)
    {
        if (! $request->user()->can('isChairmanOrManagerAndOwnDivision', [$division, $team])) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $round = $this->transferRoundService->getActiveRound($division);
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $endRound = $this->transferRoundService->getEndRound($division);

        $isRoundProcessed = $this->service->isRoundProcessed($round);
        $processBidsCount = $this->service->checkAnySucecessBidInAnyRound($division, $round);
        $processed = $this->service->getProcessBids($division, $team, $round);

        $pending = collect();
        if ($round) {
            $pending = $this->service->getPendingBids($division, $team, $request->user(), $round);
        }

        return response()->json([
            'round' => $round ? new TransferRoundResource($round) : null,
            'endRound' => $endRound ? new TransferRoundResource($endRound) : null,
            'seal_bid_deadline_repeat' => $division->getOptionValue('seal_bid_deadline_repeat'),
            'pending' => $pending,
            'processed' => $processed,
            'sealedBidDeadLinesEnum' => $sealedBidDeadLinesEnum,
            'isRoundProcess' => $division->is_round_process,
            'processBidsCount' => $processBidsCount,
            'isRoundProcessed' => $isRoundProcessed,
            'is_round_process' => $division->is_round_process,
            'isManager' => $request->user()->can('ownLeagues', $division),
            'messages' => __('sealbid.transfer'),
        ]);
    }

    public function getTeamsDetails(Division $division, Team $team, Request $request)
    {
        if (! $request->user()->can('ownTeamAndOwnDivision', [$division, $team])) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $round = $this->transferRoundService->getActiveRound($division);
        $isRoundProcessed = $this->service->isRoundProcessed($round);

        if (!$round || $isRoundProcessed) {
            return response()->json([
                'round' => $round ? new TransferRoundResource($round) : null,
                'messages' => __('sealbid.transfer'),
                'isRoundProcessed' => $isRoundProcessed,
            ]);
        }

        $isMobile = true;

        $playersData = [];
        $team = $this->service->getTeamDetails($division, $team, $round);
        $isGk = player_position_short(AllPositionEnum::GOALKEEPER);
        $positions = $this->auctionCommanService->getPositions($division);
        $clubs = $this->clubService->getPremierClubsShortCode();
        $teams = $division->divisionTeams()->approve()->get()->pluck('name', 'id');
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $moneyBack = $division->getOptionValue('money_back');
        $sealBidIncrement = $division->getOptionValue('seal_bid_increment');
        $sealBidMinimum = $division->getOptionValue('seal_bid_minimum');
        $maxSealBidsPerTeamPerRound = $division->getOptionValue('max_seal_bids_per_team_per_round');
        $maxClubPlayers = $division->getOptionValue('default_max_player_each_club');
        $seasonFreeAgentTransferLimit = $division->getOptionValue('season_free_agent_transfer_limit');
        $monthlyFreeAgentTransferLimit = $division->getOptionValue('monthly_free_agent_transfer_limit');
        $teamClubsPlayer = $this->service->getClubIdWithCount($team->id);
        $teamPlayers = $this->service->getTeamPlayersPositionWise($division, $team, $isMobile);
        $selectedPlayers = $this->service->getSelectedPlayers($division, $team, $round, $isMobile);
        $bidIncrementDecimalPlace = get_decimal_part_of_a_number(floatval($sealBidIncrement));
        //$playerInitialCount = $this->service->playerInitials($teamPlayers, $selectedPlayers);

        foreach ($selectedPlayers as $transfer) {
            $playersData[] = [
                'id' => $transfer->id,
                'club_id' => $transfer->club_id,
                'club_id_out' => $transfer->club_id_out,
                'oldPlayerId' => $transfer->player_out,
                'newPlayerId' => $transfer->player_in,
                'oldPlayerAmount' => $transfer->transfer_value,
                'newPlayerAmount' => $transfer->amount,
            ];

            if (isset($teamClubsPlayer[$transfer->club_id])) {
                if ($teamClubsPlayer[$transfer->club_id] < $maxClubPlayers) {
                    $teamClubsPlayer[$transfer->club_id] = $teamClubsPlayer[$transfer->club_id] + 1;
                }
            } else {
                $teamClubsPlayer[$transfer->club_id] = 1;
            }

            if (isset($teamClubsPlayer[$transfer->club_id_out])) {
                $teamClubsPlayer[$transfer->club_id_out] = $teamClubsPlayer[$transfer->club_id_out] - 1;
            }
        }

        unset($team->teamDivision);

        return response()->json([
            'players' => $teamPlayers,
            'team' => $team,
            'positions' => $positions,
            'clubs' => $clubs->toArray(),
            'teams' => $teams,
            'isGk' => $isGk,
            'selectedPlayers' => $selectedPlayers,
            'bidIncrementDecimalPlace' => $bidIncrementDecimalPlace,
            //'playerInitialCount' => $playerInitialCount,
            'isRoundProcessed' => $isRoundProcessed,
            'round' => new TransferRoundResource($round),
            'maxClubPlayers' => $maxClubPlayers,
            'playersData' => $playersData,
            'assetUrl' => asset('assets/frontend'),
            'messages' => __('sealbid.transfer'),
            'teamClubsPlayer' => $teamClubsPlayer->toArray(),
            'moneyBackEnum' => MoneyBackEnum::toArray(),
            'mergeDefenders' => $mergeDefenders,
            'defensiveMidfields' => $defensiveMidfields,
            'moneyBack' => $moneyBack,
            'sealBidIncrement' => $sealBidIncrement,
            'sealBidMinimum' => $sealBidMinimum,
            'maxSealBidsPerTeamPerRound' => $maxSealBidsPerTeamPerRound,
            'seasonFreeAgentTransferLimit' => $seasonFreeAgentTransferLimit,
            'monthlyFreeAgentTransferLimit' => $monthlyFreeAgentTransferLimit,
            'pitch' => config('fantasy.pitch_url'),
        ]);
    }

    public function getPlayersData(Division $division, Team $team, Request $request)
    {
        if (! $request->user()->can('ownTeam', $team)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $isMobile = true;

        $dataTabs = $this->service->getPlayers($division, $team, $request->all(), $isMobile);

        return response()->json([
            'data' => $dataTabs,
        ]);
    }

    public function store(Division $division, Team $team, Request $request)
    {
        $round = $this->transferRoundService->getActiveRound($division);

        if (! $request->user()->can('ownTeamWithActiveRound', [$team, $round])) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(), [
            'json_data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->messages()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        info('Start sealbid transfer temp data for mobile '.now());

        $json_data = collect($request->get('json_data'));
        $json_data_count = $json_data->count();

        info($json_data->toArray());

        if ($json_data_count) {
            $formation = $this->service->formationValidation($division, $team, $json_data);
            $budget = $this->service->checkbudgetValidation($division, $team, $round, $json_data);

            $sealBidIncrement = $division->getOptionValue('seal_bid_increment');
            $bidIncrement = $this->service->checkBidIncrement($sealBidIncrement, $json_data);

            $sealBidMinimum = $division->getOptionValue('seal_bid_minimum');
            $maxSealBidsPerTeamPerRound = $division->getOptionValue('max_seal_bids_per_team_per_round');

            $maxClubPlayers = $division->getOptionValue('default_max_player_each_club');
            $clubQuota = $this->service->checkClubQuota($team, $maxClubPlayers, $json_data);

            $monthlyTransferLimit = $this->service->checkMonthlyTransferLimit($division, $team, $json_data_count);
            $seasonTransferLimit = $this->service->checkSeasonTransferLimit($division, $team, $json_data_count);

            $validator->after(function ($validator) use ($formation, $budget, $maxSealBidsPerTeamPerRound, $json_data, $sealBidMinimum, $bidIncrement, $clubQuota, $monthlyTransferLimit, $seasonTransferLimit) {
                if (! $formation) {
                    $validator->errors()->add('json_data_formation', __('sealbid.transfer.formation'));
                }
                if ($budget < 0) {
                    $validator->errors()->add('json_data_budget', __('sealbid.transfer.budget'));
                }
                if ($json_data->count() > $maxSealBidsPerTeamPerRound) {
                    $validator->errors()->add('json_data_bid_per_round', __('sealbid.transfer.max_bid_per_round'));
                }
                if ($json_data->min('newPlayerAmount') < $sealBidMinimum) {
                    $validator->errors()->add('json_data_minimum_bid', __('sealbid.transfer.bid_minimum'));
                }
                if (! $bidIncrement) {
                    $validator->errors()->add('json_data_min_bid_increment', __('sealbid.transfer.bid_increment'));
                }
                if (! $clubQuota) {
                    $validator->errors()->add('json_data_club_quota', __('sealbid.transfer.club_quota'));
                }
                if (! $monthlyTransferLimit) {
                    $validator->errors()->add('json_data_month_quota', __('messages.transfer.monthly_quota.error'));
                }

                if (! $seasonTransferLimit) {
                    $validator->errors()->add('json_data_season_quota', __('messages.transfer.seasons_quota.error'));
                }
            });

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->messages()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $insert = $this->service->store($team, $round, $json_data);

        if ($insert) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getPlayerDetails(Division $division, Team $team, Request $request)
    {
        if (! $request->user()->can('ownTeam', $team)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $newPlayerId = $request->get('newPlayerId');
        $oldPlayerId = $request->get('oldPlayerId');
        $amount = $request->get('amount');

        $newValue = $this->service->getPlayerDetails($division, $team, $newPlayerId, $amount);
        $isGk = player_position_short(AllPositionEnum::GOALKEEPER);
        $sealBidIncrement = $division->getOptionValue('seal_bid_increment');
        $bidIncrementDecimalPlace = get_decimal_part_of_a_number(floatval($sealBidIncrement));

        $playerInitialCount = collect();

        if ($newValue) {
            $playerKey = $newValue->playerPositionShort;

            return response()->json([
                'newValue' => $newValue,
                'playerKey' => $playerKey,
                'newPlayerId' => $newPlayerId,
                'oldPlayerId' => $oldPlayerId,
                'isGk' => $isGk,
                'bidIncrementDecimalPlace' => $bidIncrementDecimalPlace,
                'playerInitialCount' => $playerInitialCount,
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function processManualStart(Division $division, Request $request)
    {
        $round = $this->transferRoundService->getEndRound($division);

        if(!$round) {
            
            return response()->json(['status' => 'success', 'message' => 'Bids already processed.'], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('chairmanCanProcessBids', [$division, $round])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $result = $this->service->sealBidProcessManual($division, $round);

        if ($result) {

            return response()->json(['status' => 'success', 'message' => 'Bid Round '.$round->number.' is now completed'], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function processSingleBid(Division $division, SealedBidTransfer $sealbid, Request $request)
    {
        $round = $sealbid->round;

        if (! $request->user()->can('chairmanCanProcessBids', [$division, $round])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if($sealbid->manually_process_status == ManuallyProcessStatusEnum::COMPLETED && $sealbid->is_process) {

            return response()->json(['status' => 'success', 'message' => 'Bid already processed'], JsonResponse::HTTP_OK);
        }

        $team = $sealbid->team;

        $isBidProcessable = $this->service->isBidProcessable($division, $sealbid, $team, $round);

        if ($isBidProcessable['status']) {

            $valid = $this->service->checkTeamPlayerValidation($division, $team, $sealbid);

            if ($valid['status']) {

                $sealBidData = ['status' => OnlineSealedBidStatusEnum::WON, 'is_process' => true, 'manually_process_status' => $sealbid->manually_process_status];

                $this->onlineSealedBidTransferService->updateStatus($sealbid, $sealBidData);
                $this->service->processSingleBid($division, $team, $sealbid);

                return response()->json(['status' => 'success', 'message' => $valid['message']], JsonResponse::HTTP_OK);

            } else {

                return response()->json(['status' => 'error', 'message' => $valid['message']], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

        } else {

            if(Arr::has($isBidProcessable, 'error_but_scecess') && Arr::get($isBidProcessable, 'error_but_scecess')) {

                return response()->json(['status' => 'success', 'message' => $isBidProcessable['message']], JsonResponse::HTTP_OK);
            }
        }

        return response()->json(['status' => 'error', 'message' => $isBidProcessable['message']], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function roundClose(Division $division, Request $request)
    {
        info('Round close process start '.now());

        $round = $this->transferRoundService->getEndRound($division);

        if(!$round) {
            
            return response()->json(['status' => 'success', 'message' => 'Round already closed.'], JsonResponse::HTTP_OK);
        }

        if (! $request->user()->can('chairmanCanProcessBids', [$division, $round])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $isRoundProcessed = $this->service->isRoundProcessed($round);

        if ($isRoundProcessed) {
            $this->service->roundClose($division, $round);

            return response()->json(['status' => 'success', 'message' => 'Round '.$round->number.' is closed now.'], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
