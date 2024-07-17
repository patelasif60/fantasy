<?php

namespace App\Repositories;

use App\Enums\TransferTypeEnum;
use App\Models\DivisionTeam;
use App\Models\PlayerContract;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class PlayerContractRepository
{
    public function create($data)
    {

        //Update Existing Open Contract with new Start Date
        $existingContracts = $this->getExistingContract($data, ['end_date' => null])->all();

        if ($existingContracts) {
            $toDeactivate = true;
            foreach ($existingContracts as $existingContract) {
                $updatedata['end_date'] = Carbon::createFromFormat('Y-m-d', $data['start_date'])->subDay()->format('Y-m-d');
                $updatedContract = $this->update((object) $existingContract, $updatedata, $toDeactivate);
            }
        }

        $create_array = [
            'player_id'     => $data['player_id'],
            'club_id'       => $data['club_id'],
            'position'      => $data['position'],
            'start_date'    => $data['start_date'],
            'is_active'     => Arr::has($data, 'is_active'),
        ];

        if (! empty($data['end_date'])) {
            $create_array['end_date'] = $data['end_date'];
        } else {
            $create_array['end_date'] = null;
        }

        return PlayerContract::create($create_array);
    }

    public function update($playercontract, $data, $toDeactivate = false)
    {
        if (! $toDeactivate) {
            $update_array = [
                'club_id'       => $data['club_id'],
                'position'      => $data['position'],
                'start_date'    => $data['start_date'],
                'is_active'     => Arr::has($data, 'is_active'),
            ];
        }

        if (! empty($data['end_date'])) {
            $update_array['end_date'] = $data['end_date'];
        } else {
            $update_array['end_date'] = null;
        }
        $playercontract->fill($update_array);

        $playercontract->save();

        return $playercontract;
    }

    public function getExistingContract($data, $where)
    {
        return PlayerContract::where($where)
           ->where('player_id', $data['player_id'])
           ->where('start_date', '<=', $data['start_date'])
           ->get();
    }

    public function getContractPlayers($where, $fixtureDate)
    {
        return PlayerContract::select('position', 'player_id')->where($where)
            //->where('is_active', true)
            ->where(function ($query) use ($fixtureDate) {
                $query->where('start_date', '<=', Carbon::now())
                 ->orWhere('start_date', '<=', $fixtureDate);
            })
            ->where(function ($query) use ($fixtureDate) {
                $query->where('end_date', '>=', Carbon::now())
                 ->orWhere('end_date', '>=', $fixtureDate)
                 ->orWhereNull('end_date');
            })
            ->with(['player'=>function ($query) {
                $query->select('id', 'first_name', 'last_name')
                        ->orderBy('first_name')
                        ->orderBy('last_name');
            }])->orderBy('position')->get();
    }

    public function getPlayerContractWithClub($team = null, $data = null)
    {
        $query = PlayerContract::join('players', 'players.id', '=', 'player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->select('players.first_name', 'players.last_name', 'clubs.name', 'player_contracts.position', 'player_contracts.player_id')
            ->where('player_contracts.is_active', true)
            ->whereNull('player_contracts.end_date')
            ->where('clubs.is_premier', true)
            ->orderBy('players.first_name');

        if ($team) {
            $division = Team::find($team)->teamDivision[0];
            $teamIds = DivisionTeam::where('division_id', $division->id)->pluck('team_id');
            $query = $query->WhereNotIn('player_contracts.player_id', TeamPlayerContract::whereIn('team_id', $teamIds)->active()->pluck('player_id'));

            if (array_get($data, 'auction_type') == TransferTypeEnum::AUCTION) {
                if ($division->auction_date &&
                   now()->format(config('fantasy.db.date.format')) >= $division->auction_date
                ) {
                    $query = $query->where('player_contracts.start_date', '<=', $division->auction_date);
                }
            }
        }

        return $query->get();
    }
}
