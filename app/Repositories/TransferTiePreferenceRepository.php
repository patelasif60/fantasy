<?php

namespace App\Repositories;

use App\Models\TeamPoint;
use App\Models\TransferTiePreference;

class TransferTiePreferenceRepository
{
    public function create($data, $round)
    {
        foreach ($data as $key => $value) {
            TransferTiePreference::create(['team_id' => $key, 'number' => $value, 'transfer_rounds_id' => $round->id]);
        }

        return true;
    }

    public function delete($data, $round)
    {
        $delete = TransferTiePreference::whereIn('team_id', $data)
        ->where('transfer_rounds_id', $round->id)
        ->delete();

        return $delete;
    }

    public function getTeamPoints($teams)
    {
        return TeamPoint::whereIn('team_id', $teams)
                ->selectRaw('COALESCE(SUM(total),0) AS total_points, COALESCE(SUM(goal),0) AS total_goal, COALESCE(SUM(assist),0) AS total_assist, team_id')
                ->groupBy('team_id')
                ->get();
    }

    public function getTransferTieNumber($teams)
    {
        return TransferTiePreference::whereIn('team_id', $teams)->get()->pluck('number', 'team_id')->toArray();
    }

    public function getTransferTieNumbers($teams)
    {
        return TransferTiePreference::whereIn('team_id', $teams)->get();
    }
}
