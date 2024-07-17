<?php

namespace App\Repositories;

use App\Enums\AuctionTypesEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Enums\TransferTypeEnum;
use App\Models\Division;
use App\Models\DivisionTeam;
use App\Models\SealedBidTransfer;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use App\Models\TransferRound;

class OnlineSealedBidTransferRepository
{
    public function getActiveBidDivision()
    {
        return Division::join('transfer_rounds', 'transfer_rounds.division_id', '=', 'divisions.id')
                ->where('transfer_rounds.end', '<=', now())
                ->where('transfer_rounds.is_process', TransferRoundProcessEnum::UNPROCESSED)
                ->where('divisions.auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
                ->select('divisions.*')
                ->get();
    }

    public function getBidRoundData($transferRound)
    {
        return SealedBidTransfer::join('transfer_rounds', 'transfer_rounds.id', '=', 'sealed_bid_transfers.transfer_rounds_id')
                ->leftJoin('transfer_tie_preferences', function ($join) use ($transferRound) {
                    $join->on('transfer_tie_preferences.team_id', '=', 'sealed_bid_transfers.team_id')
                         ->where('transfer_tie_preferences.transfer_rounds_id', $transferRound->id);
                })
                ->whereNull('sealed_bid_transfers.status')
                ->where('transfer_rounds.is_process', TransferRoundProcessEnum::UNPROCESSED)
                ->where('transfer_rounds.id', $transferRound->id)
                ->select('sealed_bid_transfers.*', 'transfer_tie_preferences.number')
                ->get();
    }

    public function checkUnProcessRoundCount($division, $endDate)
    {
        return TransferRound::where('transfer_rounds.is_process', TransferRoundProcessEnum::UNPROCESSED)
                        ->where('transfer_rounds.end', '>', $endDate)
                        ->where('transfer_rounds.division_id', $division->id)
                        ->count();
    }

    public function createTeamPlayerContract($sealBid, $division)
    {
        $transfer = null;

        if ($sealBid) {
            $date = now()->format(config('fantasy.db.datetime.format'));
            $team = Team::find($sealBid->team_id);
            $teamBudget = $this->getLatestTeamBudget($team, $sealBid->player_out, $division);
            $playerOut = TeamPlayerContract::where('player_id', $sealBid->player_out)
                                        ->where('team_id', $sealBid->team_id)
                                        ->whereNull('end_date')
                                        ->first();

            if ($playerOut) {
                $team->fill([
                    'team_budget' => ($teamBudget - $sealBid->amount),
                ]);

                $team->save();

                $playerOut->fill(['end_date' =>  $date])->save();

                TeamPlayerContract::create([
                    'team_id' => $sealBid->team_id,
                    'player_id' => $sealBid->player_in,
                    'is_active' => $playerOut->is_active,
                    'start_date' => $date,
                    'end_date' =>  null,
                ]);

                $transfer = Transfer::create([
                    'team_id' => $sealBid->team_id,
                    'player_in' => $sealBid->player_in,
                    'player_out' => $sealBid->player_out,
                    'transfer_type' => TransferTypeEnum::SEALEDBIDS,
                    'transfer_value' => $sealBid->amount,
                    'transfer_date' => $date,
                ]);

                $teamPlayerRepository = app(TeamPlayerRepository::class);
                $teamPlayerRepository->addTransferQuata($sealBid->team_id);
            }
        }

        return $transfer;
    }

    public function getLatestTeamBudget($team, $player, $division)
    {
        $teamBudget = $team->team_budget;
        $moneyBack = $division->getOptionValue('money_back');

        $transferBudget = Transfer::where('player_in', $player)
                ->where('team_id', $team->id)
                ->whereNotIn('transfer_type', ['substitution', 'supersub'])
                ->orderBy('id', 'desc')->first();

        if ($moneyBack == MoneyBackEnum::HUNDERED_PERCENT) {
            return $teamBudget + $transferBudget->transfer_value;
        }

        if ($moneyBack == MoneyBackEnum::FIFTY_PERCENT) {
            return $teamBudget + ($transferBudget->transfer_value / 2);
        }

        return $teamBudget;
    }

    public function updateStatus($onlineSealedBid, $data)
    {
        $onlineSealedBid->fill([
            'status' => $data['status'],
            'is_process' => $data['is_process'],
            'manually_process_status' => $data['manually_process_status'],
        ]);

        return $onlineSealedBid->save();
    }

    public function getTeamPlayerDeatils($endRound)
    {
        return SealedBidTransfer::join('teams', 'teams.id', '=', 'sealed_bid_transfers.team_id')
                        ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
                        ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
                        ->join('consumers', 'teams.manager_id', '=', 'consumers.id')
                        ->join('users', 'consumers.user_id', '=', 'users.id')
                        ->join('players as playerIn', 'sealed_bid_transfers.player_in', '=', 'playerIn.id')
                        ->join('players as playerOut', 'sealed_bid_transfers.player_out', '=', 'playerOut.id')
                        ->where('sealed_bid_transfers.transfer_rounds_id', $endRound->id)
                        ->where('sealed_bid_transfers.status', OnlineSealedBidStatusEnum::WON)
                        ->where('sealed_bid_transfers.is_process', true)
                        ->select('users.first_name as manager_first_name', 'users.last_name as manager_last_name', 'users.email as manager_email', 'playerIn.first_name as player_in_first_name', 'playerIn.last_name as player_in_last_name', 'playerOut.first_name as player_out_first_name', 'playerOut.last_name as player_out_last_name', 'sealed_bid_transfers.amount', 'sealed_bid_transfers.team_id', 'divisions.name as  division_name')
                        ->get();
    }

    public function isRoundCompleted($round)
    {
        return SealedBidTransfer::where('transfer_rounds_id', $round->id)
        ->whereNotNull('status')
        ->where('is_process', false)
        ->count();
    }

    public function sealBidManuallyProcessStatusUpdate($round)
    {
        return SealedBidTransfer::where('transfer_rounds_id', $round->id)
                ->update(['manually_process_status' => 'completed']);
    }

    public function checkAlreadyInTeam($division, $onlineSealedBid)
    {
        $alreadyInTeam = DivisionTeam::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'division_teams.team_id')
                ->where('division_teams.division_id', $division->id)
                ->where('team_player_contracts.player_id', $onlineSealedBid->player_in)
                ->whereNull('team_player_contracts.end_date')
                ->first();

        return $alreadyInTeam;
    }
}
