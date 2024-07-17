<?php

namespace App\Repositories;

use App\Enums\SquadSizeEnum;
use App\Enums\TransferErrorEnum;
use App\Enums\TransferTypeEnum;
use App\Models\Division;
use App\Models\Player;
use App\Models\PlayerContract;
use App\Models\SupersubTeamPlayerContract;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Arr;

class TeamPlayerRepository
{
    const PREVIOUS_DAY = 1;

    public function __construct(TransferRepository $transferRepository, SupersubTeamPlayerContract $supersubTeamPlayerContract)
    {
        $this->transferRepository = $transferRepository;
        $this->supersubTeamPlayerContract = $supersubTeamPlayerContract;
    }

    public function store($data, $team_id, $player_id)
    {
        $savedContract = null;
        $isCreate = false;
        if (isset($data['start_date_new'])) {
            $isCreate = true;
            //Create Contracts
            $createArray = [];
            foreach ($data['start_date_new'] as $id => $value) {
                $createArray = [
                    'player_id' =>  $player_id,
                    'team_id'   =>  $team_id,
                    'start_date'=>  ($data['start_date_new'][$id] ? $data['start_date_new'][$id] : null),
                    'end_date'  =>  ($data['end_date_new'][$id] ? $data['end_date_new'][$id] : null),
                    'is_active' =>  (isset($data['is_active_new'][$id])),
                ];
            }
            $savedContract = $this->create($createArray);
        }
        //update Contracts;
        foreach ($data['start_date'] as $id => $value) {
            // Update Open Contracts with Start Date
            if ($data['end_date'][$id] == null) {
                $data['end_date'][$id] = ($isCreate) ? max($data['start_date_new']) : null;
            }
            $updateData = [
                'start_date'=> ($data['start_date'][$id] ? $data['start_date'][$id] : null),
                'end_date'   => ($data['end_date'][$id] ? $data['end_date'][$id] : null),
                'is_active'  => (isset($data['is_active'][$id])),
            ];
            $contract = TeamPlayerContract::find($id);
            $savedContract = $this->update($updateData, $contract);
        }

        return ($savedContract) ? true : false;
    }

    public function create($data)
    {
        return TeamPlayerContract::create($data);
    }

    public function update($data, $contract)
    {
        $contract->fill($data);
        $contract->save();

        return $contract;
    }

    public function listContracts($team_id, $player_id, $where = [])
    {
        $team_player_contract = new TeamPlayerContract();
        if (! empty($where)) {
            $team_player_contract->where($where);
        }

        return $team_player_contract->where([
            'team_id'   =>$team_id,
            'player_id' =>$player_id,
        ])
        ->orderByDesc('start_date', 'end_date')
        ->get();
    }

    /**
     * If player out not selected
     * check transfer possible.
     */
    public function checkTransferPossible($data)
    {
        $totalPlayers = TeamPlayerContract::where('team_id', $data['team_id'])->active()->count();
        $lineUp = TeamPlayerContract::where('team_id', $data['team_id'])->lineUp()->count();

        /*
         * Check team size if not full
         * else send error
        */
        if (SquadSizeEnum::SQUAD_SIZE_MAX == $totalPlayers) {
            return TransferErrorEnum::TEAM_FULL;
        }

        /*
         * With in team transfer
         * Check  Lineup size if not full
         * else send error
        */
        if ($data['transfer_type'] == TransferTypeEnum::SUBSTITUTION || $data['transfer_type'] == TransferTypeEnum::SUPERSUB) {
            if ($lineUp == SquadSizeEnum::SQUAD_LINEUP) {
                return TransferErrorEnum::TEAM_LINEUP_FULL;
            }
        }

        return true;
    }

    /**
     * Create a new contracts.
     * update existing contracts.
     * @param data for transfer
     */
    public function createContracts($data)
    {

        /**
         * get team total
         * Lineup players
         * Substitute Players.
         */
        $lineUp = TeamPlayerContract::where('team_id', $data['team_id'])->lineUp()->count();
        $substitute = TeamPlayerContract::where('team_id', $data['team_id'])->substitute()->count();

        /*
         * With in team transfers
        */
        if ($data['transfer_type'] == TransferTypeEnum::SUBSTITUTION || $data['transfer_type'] == TransferTypeEnum::SUPERSUB) {
            /**
             * End current substitute contract.
             */
            $playerIn = $this->getTeamPlayerContract($data['player_in'], $data['team_id']);
            $this->updateCurrentContract($data, $playerIn);

            /*
             * Create lineup contract
            */
            $data['player'] = $data['player_in'];
            $data['is_active'] = true;
            $this->createPlayerContract($data);

            if (! is_null($data['player_out'])) {

                /**
                 * End current lineup contract.
                 */
                $playerOut = $this->getTeamPlayerContract($data['player_out'], $data['team_id']);
                $this->updateCurrentContract($data, $playerOut);

                /*
                 * create substitute contract
                */
                $data['player'] = $data['player_out'];
                $data['is_active'] = false;
                $this->createPlayerContract($data);
            }
        } else {

            /**
             * Other players transfer in team.
             * Outside team transfer
             * Other players transfer in team.
             */
            $playerIn = $this->getTeamPlayerContract($data['player_in'], $data['team_id']);

            if (! is_null($playerIn) && is_null($playerIn->end_date)) {
                /*
                 * if player already has contract running end it
                */
                $this->updateCurrentContract($data, $playerIn);
            }

            if (! is_null($data['player_out'])) {
                $playerOut = $this->getTeamPlayerContract($data['player_out'], $data['team_id']);

                /*
                 * create new contract based on
                 * player out contract
                */
                $data['player'] = $data['player_in'];
                $data['is_active'] = $playerOut->is_active;
                $this->createPlayerContract($data);

                /*
                 * End current contract lineup or substitute
                */
                $this->updateCurrentContract($data, $playerOut);
            } else {
                /*
                 * create new contract based on size
                 * first priority to lineup
                 * else substitute
                */

                $data['player'] = $data['player_in'];
                if ($lineUp < SquadSizeEnum::SQUAD_LINEUP) {
                    $data['is_active'] = true;
                } else {
                    $data['is_active'] = false;
                }

                $this->createPlayerContract($data);
            }
        }
    }

    public function createMissedContracts($contracts)
    {
        $missedContract = [];
        foreach ($contracts as $contract) {
            $where = [
                'team_id'   => $contract['team_id'],
                'player_id' => $contract['player_id'],
            ];

            if ($this->checkSeasonStartDateOverlap($where, $contract['start_date'])->count() == 0) {
                $missedContract[] = $this->create($contract);
            }
        }

        return $missedContract;
    }

    /**
     * Get team player contracts.
     */
    public function getTeamPlayerContract($player, $team = null)
    {
        $query = TeamPlayerContract::where('player_id', $player);
        if ($team) {
            $query = $query->where('team_id', $team);
        }

        return $query->orderBy('id', 'desc')->first();
    }

    /**
     * update existing contract.
     */
    public function updateCurrentContract($data, $contract)
    {
        $contract->fill([
            'is_active' => false,
            'end_date' =>  $data['transfer_date'],
        ]);

        return $contract->save();
    }

    /**
     * create new contract.
     */
    public function createPlayerContract($data)
    {
        return TeamPlayerContract::create([
            'team_id' => $data['team_id'],
            'player_id' => $data['player'],
            'is_active' => $data['is_active'],
            'start_date' => $data['transfer_date'],
            'end_date' =>  null,
        ]);
    }

    /**
     * Get team player contracts.
     */
    public function getPlayerTeamContractsWithClub($team)
    {
        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->leftjoin('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->select('players.first_name', 'players.last_name', 'clubs.name', 'player_contracts.position', 'player_contracts.player_id', 'team_player_contracts.is_active')
            ->where('team_player_contracts.team_id', $team)
            ->whereNull('team_player_contracts.end_date')
            ->where('clubs.is_premier', true)
            ->orderBy('players.first_name')
            ->get();
    }

    public function checkSeasonStartDateOverlap($where, $start_date)
    {
        return TeamPlayerContract::where($where)
            ->whereDate('start_date', '<=', $start_date)
            ->whereNotNull('end_date');
    }

    public function getMissedPlayerContracts($teamPlayerContracts)
    {
        $playerContracts = [];

        foreach ($teamPlayerContracts as $teamPlayerContract) {
            $startDate = $teamPlayerContract->team->divisionTeam->season->start_at;

            $date = Carbon::parse($teamPlayerContract->start_date);
            $endDate = $date->subDays(self::PREVIOUS_DAY);

            $playerContracts[] = [
                'team_id'    => $teamPlayerContract->team_id,
                'player_id'  => $teamPlayerContract->player_id,
                'is_active'  => $teamPlayerContract->is_active,
                'start_date' => $startDate,
                'end_date'   => $endDate,
            ];
        }

        return $this->createMissedContracts($playerContracts);
    }

    public function getCurrentContractForTeam($team)
    {
        return TeamPlayerContract::with('player.playerContract', 'team')->whereIn('team_id', $team)->lineUp()->get();
    }

    public function swapContractsplayer($data)
    {
        foreach ($data['player'] as $dataKey=>$player) {
            $players[$dataKey] = TeamPlayerContract::where('id', $player)->orderBy('id', 'desc')->first();
        }
        foreach ($data['player'] as $playerKey=>$playerVal) {
            $this->updateCurrentContract($data, $players[$playerKey]);
            $data['player'] = $players[$playerKey]->player_id;
            $data['is_active'] = 1;
            if ($playerKey == 'in') {
                $data['team_id'] = $players['out']->team_id;
                $data['player_in'] = $players['out']->player_id;
                $data['transfer_value'] = $data['swapamt']['out'];
            } else {
                $data['team_id'] = $players['in']->team_id;
                $data['player_in'] = $players['in']->player_id;
                $data['transfer_value'] = $data['swapamt']['in'];
            }
            $this->createPlayerContract($data);
            $data['team_id'] = $players[$playerKey]->team_id;
            $data['player_out'] = $players[$playerKey]->player_id;
            $data['transfer_type'] = TransferTypeEnum::SWAPDEAL;
            $this->transferRepository->create($data);
        }
    }

    /**
     * Get team player contracts.
     */
    public function getDivisionPlayers($division)
    {
        return Division::join('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ((team_player_contracts.start_date BETWEEN player_contracts.start_date AND player_contracts.end_date) AND player_contracts.end_date IS NOT NULL) OR (player_contracts.start_date <= team_player_contracts.start_date AND player_contracts.end_date IS NULL ) ))'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')

            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')

            ->select('players.first_name as player_first_name', 'players.last_name as player_last_name', 'players.id as player_id', 'clubs.id as club_id', 'clubs.short_code as club_short_code', 'player_contracts.position', 'teams.id as team_id', 'teams.name as team_name', 'users.first_name as manager_first_name', 'users.last_name as manager_last_name', 'teams.team_budget')

            ->where('divisions.id', $division->id)
            ->whereNull('team_player_contracts.end_date')
            ->orderBy('teams.name', 'asc')
            ->orderBy('player_contracts.position', 'asc')
            ->groupBy('players.id', 'teams.id', 'clubs.id', 'player_contracts.position')
            ->get();
    }

    public function createTransfer($data)
    {
        return Transfer::create([
            'team_id' => $data['team_id'],
            'player_in' => Arr::get($data, 'player_in', null),
            'player_out' => Arr::get($data, 'player_out', null),
            'transfer_type' => $data['transfer_type'],
            'transfer_value' => $data['transfer_value'],
            'transfer_date' => $data['transfer_date'],
        ]);
    }

    public function swapPlayersContract($data)
    {
        $date = now()->format(config('fantasy.db.datetime.format'));

        foreach ($data as $key => $val) {
            $playerOut = TeamPlayerContract::where('player_id', $val['playerOut'])
            ->where('team_id', $val['playerOutTeam'])->whereNull('end_date')->first();

            $playerOutStatus = $playerOut->is_active;
            $playerOut->fill(['end_date' =>  $date])->save();

            $playerIn = TeamPlayerContract::where('player_id', $val['playerIn'])
            ->where('team_id', $val['playerInTeam'])->whereNull('end_date')->first();
            $playerInStatus = $playerIn->is_active;
            $playerIn->fill(['end_date' =>  $date])->save();

            $createContract = [];
            $createContract['team_id'] = $val['playerInTeam'];
            $createContract['player'] = $val['playerOut'];
            $createContract['is_active'] = $playerInStatus;
            $createContract['transfer_date'] = $date;
            $this->createPlayerContract($createContract);

            $createContract = [];
            $createContract['team_id'] = $val['playerOutTeam'];
            $createContract['player'] = $val['playerIn'];
            $createContract['is_active'] = $playerOutStatus;
            $createContract['transfer_date'] = $date;
            $this->createPlayerContract($createContract);

            $createTransfer = [];
            $createTransfer['team_id'] = $val['playerInTeam'];
            $createTransfer['player_in'] = $val['playerOut'];
            $createTransfer['player_out'] = $val['playerIn'];
            $createTransfer['transfer_type'] = TransferTypeEnum::SWAPDEAL;
            $boughtPrice = Transfer::where('team_id', $val['playerOutTeam'])->where('player_in', $val['playerOut'])->first()->transfer_value;
            $createTransfer['transfer_value'] = $boughtPrice;

            $createTransfer['transfer_date'] = $date;
            $this->createTransfer($createTransfer);

            $createTransfer = [];
            $createTransfer['team_id'] = $val['playerOutTeam'];
            $createTransfer['player_in'] = $val['playerIn'];
            $createTransfer['player_out'] = $val['playerOut'];
            $createTransfer['transfer_type'] = TransferTypeEnum::SWAPDEAL;
            $boughtPriceTwo = Transfer::where('team_id', $val['playerInTeam'])->where('player_in', $val['playerIn'])->first()->transfer_value;
            $createTransfer['transfer_value'] = $boughtPriceTwo;

            $createTransfer['transfer_date'] = $date;
            $this->createTransfer($createTransfer);

            $createTransfer = [];
            $createTransfer['team_id'] = $val['playerInTeam'];
            $createTransfer['transfer_type'] = TransferTypeEnum::BUDGETCORRECTION;
            $createTransfer['transfer_value'] = $val['playerInPrice'] - $val['playerOutPrice'];
            $createTransfer['transfer_date'] = $date;
            $this->createTransfer($createTransfer);

            $createTransfer = [];
            $createTransfer['team_id'] = $val['playerOutTeam'];
            $createTransfer['transfer_type'] = TransferTypeEnum::BUDGETCORRECTION;
            $createTransfer['transfer_value'] = $val['playerOutPrice'] - $val['playerInPrice'];
            $createTransfer['transfer_date'] = $date;
            $this->createTransfer($createTransfer);

            $team = Team::find($val['playerOutTeam']);
            $currentBudget = ($team->team_budget + $val['playerInPrice']) - $val['playerOutPrice'];
            $team->fill(['team_budget' => $currentBudget])->save();

            $team = Team::find($val['playerInTeam']);
            $currentBudget = ($team->team_budget + $val['playerOutPrice']) - $val['playerInPrice'];
            $team->fill(['team_budget' => $currentBudget])->save();
            $this->supersubTeamPlayerContract->updateSuperSubTeam($val['playerInTeam'], $date);
            $this->supersubTeamPlayerContract->updateSuperSubTeam($val['playerOutTeam'], $date);
            $this->addTransferQuata($val['playerInTeam']);
            $this->addTransferQuata($val['playerOutTeam']);
        }

        return true;
    }

    public function getInPlayers($team, $playersOut)
    {
        return TeamPlayerContract::where('team_id', $team)
        ->whereNotIn('player_id', $playersOut)
        ->active()
        ->pluck('player_id');
    }

    public function getPlayerPositions($player)
    {
        return Player::join('player_contracts', 'player_contracts.player_id', '=', 'players.id')
        ->whereIn('players.id', $player)
        ->select('player_contracts.position')
        ->get();
    }

    public function getTeamDivision($team)
    {
        return Team::find($team)
                ->teamDivision[0];
    }

    public function getTeam($team)
    {
        return Team::find($team);
    }

    public function getTeamBudget($team)
    {
        return $this->getTeam($team)->team_budget;
    }

    public function getTeamClubsPlayer($team, $players)
    {
        $oTeam = Team::find($team);
        $division = $oTeam->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time(now());

        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->leftjoin('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date)))Order By id desc limit 1)'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team)
            ->whereIn('team_player_contracts.player_id', $players)
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function transferPlayers($request)
    {
        $date = now()->format(config('fantasy.db.datetime.format'));
        $transferPlayersArray = json_decode($request['transferData']);
        foreach ($transferPlayersArray as $transferPlayersArrayKey => $val) {
            $createTransfer = [];
            $createTransfer['team_id'] = $val->teamId;
            $createTransfer['player_in'] = $val->boughtPlayerId;
            $createTransfer['player_out'] = $val->soldPlayerId;
            $createTransfer['transfer_type'] = TransferTypeEnum::TRANSFER;
            $createTransfer['transfer_value'] = $val->boughtAmount;
            $createTransfer['transfer_date'] = $date;
            $this->createTransfer($createTransfer);

            $playerOut = TeamPlayerContract::where('player_id', $val->soldPlayerId)->where('team_id', $val->teamId)->whereNull('end_date')->first();
            $playerOut->fill(['end_date' =>  $date])->save();
            $playerOutStatus = $playerOut->is_active;

            $createContract = [];
            $createContract['team_id'] = $val->teamId;
            $createContract['player'] = $val->boughtPlayerId;
            $createContract['is_active'] = $playerOutStatus;
            $createContract['transfer_date'] = $date;
            $this->createPlayerContract($createContract);
            $team = Team::find($val->teamId);
            $this->addTransferQuata($val->teamId);
            // $this->supersubTeamPlayerContract->updateSuperSubTeamPlayer($val->teamId, $val->soldPlayerId, $date);
        }
        $this->supersubTeamPlayerContract->updateSuperSubTeam($val->teamId, $date);

        return $team->fill(['team_budget' => $request['teamBudget']])->save();
    }

    public function transferPlayersApi($request, $team)
    {
        $date = now()->format(config('fantasy.db.datetime.format'));
        $transferPlayersArray = $request['transferData'];
        foreach ($transferPlayersArray as $transferPlayersArrayKey => $val) {

            $createTransfer = [];
            $createTransfer['team_id'] = $team->id;
            $createTransfer['player_in'] = $val['boughtPlayerId'];
            $createTransfer['player_out'] = $val['soldPlayerId'];
            $createTransfer['transfer_type'] = TransferTypeEnum::TRANSFER;
            $createTransfer['transfer_value'] = $val['boughtAmount'];
            $createTransfer['transfer_date'] = $date;
            $this->createTransfer($createTransfer);

            $playerOut = TeamPlayerContract::where('player_id', $val['soldPlayerId'])
            ->where('team_id', $team->id)
            ->whereNull('end_date')
            ->first();

            if($playerOut) {

                $playerOut->fill(['end_date' =>  $date])->save();

                $createContract = [];
                $createContract['team_id'] = $team->id;
                $createContract['player'] = $val['boughtPlayerId'];
                $createContract['is_active'] = $playerOut->is_active;
                $createContract['transfer_date'] = $date;
                $this->createPlayerContract($createContract);
            }
        }
        $this->supersubTeamPlayerContract->updateSuperSubTeam($team->id, $date);

        return $team->fill(['team_budget' => $request['teamBudget']])->save();
    }

    public function getPlayersClub($teamKey, $players)
    {
        $team = Team::find($teamKey);
        $division = $team->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time(now());

        return TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')

            ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })

            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."'))Order By id desc limit 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->selectRaw('clubs.id as club_id')
            ->whereIn('players.id', $players)
            ->where('divisions.id', $division->id)
            ->groupBy('clubs.id')
            ->pluck('club_id');
    }

    public function setSubstituteToLineup($team, $position)
    {
        info('Line up');
        $player = TeamPlayerContract::join('player_contracts', 'player_contracts.player_id', '=', 'team_player_contracts.player_id')
            ->where('team_player_contracts.team_id', $team)
            ->where('player_contracts.position', $position)
            ->where('team_player_contracts.is_active', false)
            ->whereNull('team_player_contracts.end_date')
            ->first();

        if ($player) {
            $teamPlayerContract = TeamPlayerContract::where('player_id', $player->player_id)
            ->where('team_id', $team)->first();
            $teamPlayerContract->fill(['is_active' =>  true])->save();
        }
    }

    public function getTeamPlayerPostion($player)
    {
        return PlayerContract::where('player_id', $player)
            ->whereNull('player_contracts.end_date')
            ->first('position')->position;
    }

    /**
     * Get team players.
     */
    public function getTeamPlayers($division, $teamId)
    {
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);
        $teamPlayers = Division::join('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            // ->join('player_contracts as latest_player_contracts', function ($join) {
            //     $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ((team_player_contracts.start_date BETWEEN player_contracts.start_date AND player_contracts.end_date) AND player_contracts.end_date IS NOT NULL) OR (player_contracts.start_date <= team_player_contracts.start_date AND player_contracts.end_date IS NULL ) ) LIMIT 1)'));
            // })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction', (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')

            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')

            ->select('players.first_name as player_first_name', 'players.last_name as player_last_name', 'players.id as player_id', 'clubs.id as club_id', 'clubs.short_code as club_short_code', 'player_contracts.position', 'teams.id as team_id', 'teams.name as team_name', 'users.first_name as manager_first_name', 'users.last_name as manager_last_name', 'teams.team_budget')

            ->where('divisions.id', $division->id)
            ->where('teams.id', $teamId)
            ->whereNull('team_player_contracts.end_date')
            ->whereNull('player_contracts.end_date')
            ->where('player_contracts.is_active', true)
            ->where('clubs.is_premier', true)
            ->orderBy('teams.name', 'asc')
            ->orderBy('player_contracts.position', 'asc')
            ->groupBy('players.id', 'teams.id', 'clubs.id', 'player_contracts.position')
            ->get();
        $teamPlayers->map(function ($item, $key) {
            $item->position = player_position_short($item->position);
        });

        return $teamPlayers;
    }

    public function updatePlayerAfterTransfer($teamPlayerContractId, $activeFlag)
    {
        TeamPlayerContract::where('id', $teamPlayerContractId)->update(['is_active'=>$activeFlag]);
    }

    public function updateSubPlayerAfterTransfer($playerId, $teamId)
    {
        TeamPlayerContract::where('player_id', $playerId)->where('team_id', $teamId)->whereNull('end_date')->orderBy('id', 'desc')->update(['is_active'=>false]);
    }

    public function updatePlayerData($playerId, $teamId)
    {
        $date = now();

        TeamPlayerContract::whereIn('player_id', $playerId)
                        ->where('team_id', $teamId)
                        ->whereNull('end_date')
                        ->update(['end_date' => $date]);
        $this->startNewPlayerContracts($playerId, $teamId, $date);
    }

    public function startNewPlayerContracts($playerId, $teamId, $date)
    {
        $contracts = [];

        foreach ($playerId as $player) {
            $contracts[] = [
                'team_id' => $teamId,
                'player_id' => $player,
                'is_active' => false,
                'start_date' => $date,
                'end_date' => null,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        TeamPlayerContract::insert($contracts);
    }

    public function getTeamPlayerPostions($totalPlayers)
    {
        $auctionDate = carbon_get_date_from_date_time(now());

        return player::join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')))"));
        })

            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')

            ->whereIn('players.id', $totalPlayers)
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function addTransferQuata($teamId)
    {
        $team = Team::find($teamId);
        $monthly_quota_used = $team->monthly_quota_used + 1;
        $season_quota_used = $team->season_quota_used + 1;
        $team->fill(['monthly_quota_used' =>$monthly_quota_used, 'season_quota_used'=>$season_quota_used])->save();
    }
}
