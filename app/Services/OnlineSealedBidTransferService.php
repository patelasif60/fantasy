<?php

namespace App\Services;

use App\Enums\OnlineSealedBidStatusEnum;
use App\Enums\TiePreferenceEnum;
use App\Jobs\ProcessTeamLineUpCheckAndReset;
use App\Jobs\ProcessTransferRoundClosed;
use App\Jobs\SendSealBidTransferEmail;
use App\Jobs\TransferRoundCloseEmail;
use App\Models\SupersubTeamPlayerContract;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Repositories\OnlineSealedBidRepository;
use App\Repositories\OnlineSealedBidTransferRepository;

class OnlineSealedBidTransferService
{
    /**
     * The OnlineSealedBid repository instance.
     *
     * @var OnlineSealedBidTransferRepository
     */
    protected $repository;

    /**
     * The TransnferTiePreferenceService Service instance.
     *
     * @var TransnferTiePreferenceService
     */
    protected $transnferTiePreferenceService;

    /**
     * The TransferRoundService Service instance.
     *
     * @var TransferRoundService
     */
    protected $transferRoundService;

    /**
     * Create a new service instance.
     *
     * @param OnlineSealedBidTransferRepository $repository
     */
    public function __construct(OnlineSealedBidTransferRepository $repository, TransnferTiePreferenceService $transnferTiePreferenceService, TransferRoundService $transferRoundService)
    {
        $this->repository = $repository;
        $this->transnferTiePreferenceService = $transnferTiePreferenceService;
        $this->transferRoundService = $transferRoundService;
    }

    public function getActiveBidDivision()
    {
        return $this->repository->getActiveBidDivision();
    }

    public function getplayersMaxBidAmount($onlineSealedBids)
    {
        return $onlineSealedBids->where('amount', $onlineSealedBids->max('amount'));
    }

    public function playerSortByTiePreference($maxBidPlayers, $tiePreference)
    {
        if ($tiePreference === TiePreferenceEnum::EARLIEST_BID_WINS) {
            $sortData = $maxBidPlayers->sortBy(function ($obj, $key) {
                return $obj->created_at->unix();
            });
        } elseif ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED || $tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES || $tiePreference === TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS || $tiePreference === TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS
        ) {
            $sortData = $maxBidPlayers->sortBy('number');
        } else {
            $sortData = $maxBidPlayers->shuffle();
        }

        return $sortData->first();
    }

    public function updateStatus($onlineSealedBid, $data)
    {
        return $this->repository->updateStatus($onlineSealedBid, $data);
    }

    public function transferRoundTiePreference($division, $tiePreference, $round)
    {
        $teamIds = $division->divisionTeams()->approve()->pluck('team_id');
        if ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED || $tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES) {
            $this->transnferTiePreferenceService->create($tiePreference, $teamIds, $round, $division);
        } else {
            $this->transnferTiePreferenceService->delete($teamIds, $round);
        }
    }

    public function transferRoundTiePreferenceUsingScore($division, $tiePreference, $round)
    {
        if ($tiePreference === TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS || $tiePreference === TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS) {
            $teamIds = $division->divisionTeams()->approve()->pluck('team_id');
            $this->transnferTiePreferenceService->create($tiePreference, $teamIds, $round, $division);
        }
    }

    public function getBidRoundData($transferRound)
    {
        return $this->repository->getBidRoundData($transferRound);
    }

    public function startOnlineSealedBidProcess($onlineSealedBids, $division, $endRound)
    {
        $tiePreference = $division->getOptionValue('tie_preference');
        $onlineSealedBidsGroupBy = $onlineSealedBids->groupBy('player_in');

        $playerOuts = $onlineSealedBids->pluck('player_out')->unique();
        $sealBidTeamIds = $onlineSealedBids->pluck('team_id')->unique();
        $teamPlayerContracts = TeamPlayerContract::whereIn('player_id', $playerOuts)->whereIn('team_id', $sealBidTeamIds)->whereNull('end_date')->get();

        $tempBidData = collect();
        foreach ($onlineSealedBidsGroupBy as $onlineSealedBids) {
            $maxBidPlayers = $this->getplayersMaxBidAmount($onlineSealedBids);
            $winner = $this->playerSortByTiePreference($maxBidPlayers, $tiePreference);

            foreach ($onlineSealedBids as $onlineSealedBid) {
                $teamPlayerContract = $teamPlayerContracts->where('team_id', $onlineSealedBid->team_id)->where('player_id', $onlineSealedBid->player_out)->first();
                $alreadyInTeam = $this->checkAlreadyInTeam($division, $onlineSealedBid);

                $status = ! $alreadyInTeam && ($teamPlayerContract && ($winner && $winner->team_id == $onlineSealedBid->team_id)) ? OnlineSealedBidStatusEnum::WON : OnlineSealedBidStatusEnum::LOST;
                $onlineSealedBid->status = $status;
                $tempBidData->push($onlineSealedBid);
            }
        }

        $isRoundEnd = true;
        $winBidTeams = [];
        foreach ($tempBidData->pluck('team_id')->unique() as $teamId) {
            $sealBidTeamData = $tempBidData->where('team_id', $teamId);
            $teamDataWin = clone $sealBidTeamData->where('status', OnlineSealedBidStatusEnum::WON);
            $checkTeamLineUp = false;
            if ($sealBidTeamData->count() === $teamDataWin->count()) {
                $isProcess = true;
                $checkTeamLineUp = true;
                array_push($winBidTeams, $teamId);
            } else {
                $isRoundEnd = false;
                $isProcess = false;
            }

            foreach ($sealBidTeamData as $sealBid) {
                if ($checkTeamLineUp && $sealBid->status === OnlineSealedBidStatusEnum::WON) {
                    $this->createTeamPlayerContract($sealBid, $division);
                    $manually_process_status = 'completed';
                } else {
                    $manually_process_status = 'processed';
                }
                $sealBidData = ['status' => $sealBid->status, 'is_process' => $isProcess, 'manually_process_status' => $manually_process_status];
                $this->updateStatus($sealBid, $sealBidData);
            }

            if ($checkTeamLineUp) {
                $team = Team::find($teamId);
                $this->updateSuperSubTeamPlayer($team);
                ProcessTeamLineUpCheckAndReset::dispatch($division, $team);
            }
        }

        if ($isRoundEnd) {
            ProcessTransferRoundClosed::dispatch($division, $endRound, true);
        }

        return true;
    }

    public function checkAlreadyInTeam($division, $onlineSealedBid)
    {
        return $this->repository->checkAlreadyInTeam($division, $onlineSealedBid);
    }

    public function createTeamPlayerContract($sealBid, $division)
    {
        return $this->repository->createTeamPlayerContract($sealBid, $division);
    }

    public function updateSuperSubTeamPlayer($team)
    {
        $date = now()->format(config('fantasy.db.datetime.format'));
        SupersubTeamPlayerContract::updateSuperSubTeam($team->id, $date);

        return true;
    }

    public function checkUnProcessRoundCount($division, $endDate)
    {
        return $this->repository->checkUnProcessRoundCount($division, $endDate);
    }

    public function emailToManager($round)
    {
        SendSealBidTransferEmail::dispatch($round);
    }

    public function getClubIdWithCount($teamId)
    {
        $repository = app(OnlineSealedBidRepository::class);

        return $repository->getClubIdWithCount($teamId);
    }

    public function isRoundCompleted($round)
    {
        $status = $this->repository->isRoundCompleted($round);

        return ! $status ? true : false;
    }

    public function sealBidManuallyProcessStatusUpdate($round)
    {
        $this->repository->sealBidManuallyProcessStatusUpdate($round);
    }

    public function roundClose($division, $endRound, $emailSend = null)
    {
        info('Round Close Processe Start '.$endRound->end);
        $endRound->processed();
        $this->sealBidManuallyProcessStatusUpdate($endRound);
        $newRoundCount = $this->checkUnProcessRoundCount($division, $endRound->end);

        $newRound = null;
        if (! $newRoundCount) {
            info('Check and create new round if not created');
            $newRound = $this->transferRoundService->createFromLastRound($division, $endRound);
            $this->transferRoundService->sendEmailTransferRoundCreated($division, $newRound);
        }

        if ($newRound) {
            $tiePreference = $division->getOptionValue('tie_preference');
            $this->transferRoundTiePreference($division, $tiePreference, $newRound);
        }

        if ($emailSend) {
            $this->emailToManager($endRound);
        }

        info('Transfer round closed email send to all managers');

        TransferRoundCloseEmail::dispatch($division);

        return true;
    }
}
