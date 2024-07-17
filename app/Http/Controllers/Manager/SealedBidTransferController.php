<?php

namespace App\Http\Controllers\Manager;

use JavaScript;
use Validator;
use App\Models\Team;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Enums\MoneyBackEnum;
use App\Services\ClubService;
use App\Models\SealedBidTransfer;
use App\Http\Controllers\Controller;
use App\Enums\SealedBidDeadLinesEnum;
use App\Services\AuctionCommanService;
use App\Services\TransferRoundService;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Enums\ManuallyProcessStatusEnum;
use App\Services\SealedBidTransferService;
use App\Services\OnlineSealedBidTransferService;
use App\Enums\PlayerContractPosition\AllPositionEnum;

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

    public function index(Division $division, Request $request)
    {
        $this->authorize('isChairmanOrManager', [$division, $request->user()->consumer->ownTeamDetails($division)]);

        if (! $request->user()->can('ownLeagues', $division)) {
            $ownTeams = $division->divisionTeams()
                        ->with('consumer.user')
                        ->approve()
                        ->where('manager_id', $request->user()->consumer->id)
                        ->get();
        } else {
            $ownTeams = $division->divisionTeams()
                        ->with('consumer.user')
                        ->approve()
                        ->get();
        }

        return view('manager.divisions.sealed_bid_transfer.index', compact('division', 'ownTeams'));
    }

    public function getTeamBids(Division $division, Team $team, Request $request)
    {
        $this->authorize('isChairmanOrManagerAndOwnDivision', [$division, $team]);

        $round = $this->transferRoundService->getActiveRound($division);
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $endRound = $this->transferRoundService->getEndRound($division);

        $isRoundProcessed = $this->service->isRoundProcessed($round);
        $processBidsCount = $this->service->checkAnySucecessBidInAnyRound($division, $round);

        JavaScript::put([
            'isManager' => $request->user()->can('ownLeagues', $division),
            'divisionId' => $division->id,
            'isRoundProcess' => $division->is_round_process,
        ]);

        return view('manager.divisions.sealed_bid_transfer.bids', compact('division', 'sealedBidDeadLinesEnum', 'round', 'team', 'endRound', 'isRoundProcessed', 'processBidsCount'));
    }

    public function getPrcoessBids(Division $division, Team $team, Request $request)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $round = $this->transferRoundService->getActiveRound($division);

        $dataTabs = $this->service->getProcessBids($division, $team, $round);

        return response()->json([
            'data' => $dataTabs,
        ]);
    }

    public function getPendingBids(Division $division, Team $team, Request $request)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $round = $this->transferRoundService->getActiveRound($division);

        $dataTabs = [];

        if ($round) {
            $dataTabs = $this->service->getPendingBids($division, $team, $request->user(), $round);
        }

        return response()->json([
            'data' => $dataTabs,
        ]);
    }

    public function getTeamsDetails(Division $division, Team $team, Request $request)
    {
        $this->authorize('ownTeamAndOwnDivision', [$division, $team]);

        $isMobile = false;
        $isGk = player_position_short(AllPositionEnum::GOALKEEPER);
        $round = $this->transferRoundService->getActiveRound($division);
        $isRoundProcessed = $this->service->isRoundProcessed($round);

        $team = $this->service->getTeamDetails($division, $team, $round);
        $playersData = [];

        if ($round && !$isRoundProcessed) {
            $positions = $this->auctionCommanService->getPositions($division);
            $clubs = $this->clubService->getPremierClubsShortCode();
            $teams = $division->divisionTeams()->approve()->get()->pluck('name', 'id');
            $mergeDefenders = $division->getOptionValue('merge_defenders');
            $defensiveMidfields = $division->getOptionValue('defensive_midfields');
            $moneyBack = $division->getOptionValue('money_back');
            $sealBidIncrement = $division->getOptionValue('seal_bid_increment');
            $sealBidMinimum = $division->getOptionValue('seal_bid_minimum');
            $maxSealBidsPerTeamPerRound = $division->getOptionValue('max_seal_bids_per_team_per_round');
            $teamClubsPlayer = $this->service->getClubIdWithCount($team->id);
            $teamPlayers = $this->service->getTeamPlayersPositionWise($division, $team, $isMobile);
            $selectedPlayers = $this->service->getSelectedPlayers($division, $team, $round, $isMobile);
            $bidIncrementDecimalPlace = get_decimal_part_of_a_number(floatval($sealBidIncrement));
            $playerInitialCount = $this->service->playerInitials($teamPlayers, $selectedPlayers);
            $maxClubPlayers = $division->getOptionValue('default_max_player_each_club');

            $seasonFreeAgentTransferLimit = $division->getOptionValue('season_free_agent_transfer_limit');
            $monthlyFreeAgentTransferLimit = $division->getOptionValue('monthly_free_agent_transfer_limit');

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

            JavaScript::put([
                'maxClubPlayers' => $maxClubPlayers,
                'playersData' => $playersData,
                'moneyBackEnum' => MoneyBackEnum::toArray(),
                'mergeDefenders' => $mergeDefenders,
                'defensiveMidfields' => $defensiveMidfields,
                'moneyBack' => $moneyBack,
                'sealBidIncrement' => $sealBidIncrement,
                'sealBidMinimum' => $sealBidMinimum,
                'maxSealBidsPerTeamPerRound' => $maxSealBidsPerTeamPerRound,
                'seasonFreeAgentTransferLimit' => $seasonFreeAgentTransferLimit,
                'monthlyFreeAgentTransferLimit' => $monthlyFreeAgentTransferLimit,
                'teamClubsPlayer' => $teamClubsPlayer,
                'team' => $team,
                'messages' => __('sealbid.transfer'),
                'assetUrl' => asset('assets/frontend'),
                'isGk' => $isGk,
            ]);
        }

        return view('manager.divisions.sealed_bid_transfer.team', compact('teamPlayers', 'division', 'team', 'positions', 'clubs', 'teams', 'isGk', 'selectedPlayers', 'bidIncrementDecimalPlace', 'playerInitialCount', 'isRoundProcessed', 'round'));
    }

    public function getPlayersData(Division $division, Team $team, Request $request)
    {
        $this->authorize('ownTeam', $team);

        $isMobile = false;

        $dataTabs = $this->service->getPlayers($division, $team, $request->all(), $isMobile);

        return response()->json([
            'data' => $dataTabs,
        ]);
    }

    public function store(Division $division, Team $team, Request $request)
    {
        $round = $this->transferRoundService->getActiveRound($division);

        $this->authorize('ownTeamWithActiveRound', [$team, $round]);

        $validator = Validator::make($request->all(), [
            'json_data' => 'required|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        info('Start sealbid transfer temp data '.now());

        $json_data = collect(json_decode($request->get('json_data'), true));
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
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $insert = $this->service->store($team, $round, $json_data);

        if ($insert) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        info('End sealbid transfer temp data '.now());

        return redirect()->route('manage.transfer.sealed.bid.bids', ['division' => $division, 'team' => $team]);
    }

    public function getPlayerDetails(Division $division, Team $team, Request $request)
    {
        $this->authorize('ownTeam', $team);

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

            return view('manager.divisions.sealed_bid_transfer.partials.add-player', compact('newValue', 'playerKey', 'newPlayerId', 'oldPlayerId', 'isGk', 'bidIncrementDecimalPlace', 'playerInitialCount'));
        }
    }

    public function processManualStart(Division $division)
    {
        $round = $this->transferRoundService->getEndRound($division);

        $this->authorize('chairmanCanProcessBids', [$division, $round]);

        $result = $this->service->sealBidProcessManual($division, $round);

        if ($result) {
            flash('Bid Round '.$round->number.' is now completed')->success();
        } else {
            flash('Something went wrong.')->error();
        }

        return redirect()->back();
    }

    public function processSingleBid(Division $division, SealedBidTransfer $sealbid)
    {
        $round = $sealbid->round;

        $this->authorize('chairmanCanProcessBids', [$division, $round]);

        if($sealbid->manually_process_status == ManuallyProcessStatusEnum::COMPLETED && $sealbid->is_process) {

            return redirect()->back();
        }

        $team = $sealbid->team;

        $isBidProcessable = $this->service->isBidProcessable($division, $sealbid, $team, $round);

        if ($isBidProcessable['status']) {
            $valid = $this->service->checkTeamPlayerValidation($division, $team, $sealbid);

            if ($valid['status']) {
                $sealBidData = ['status' => OnlineSealedBidStatusEnum::WON, 'is_process' => true, 'manually_process_status' => $sealbid->manually_process_status];
                $this->onlineSealedBidTransferService->updateStatus($sealbid, $sealBidData);

                $this->service->processSingleBid($division, $team, $sealbid);

                flash($valid['message'])->success();
            } else {
                flash($valid['message'])->error();
            }
        } else {
            flash($isBidProcessable['message'])->error();
        }

        return redirect()->back();
    }

    public function roundClose(Division $division)
    {
        info('Round close process start '.now());

        $round = $this->transferRoundService->getEndRound($division);

        $this->authorize('chairmanCanProcessBids', [$division, $round]);

        $isRoundProcessed = $this->service->isRoundProcessed($round);

        if ($isRoundProcessed) {
            $this->service->roundClose($division, $round);

            flash('Round '.$round->number.' is closed now.')->success();
        } else {
            flash('Something went wrong')->error();
        }

        return redirect()->back();
    }

    public function isJobExecuted(Division $division)
    {
        $data = $this->service->isJobExecuted($division);

        return response()->json([
            'data' => $data,
        ]);
    }
}
