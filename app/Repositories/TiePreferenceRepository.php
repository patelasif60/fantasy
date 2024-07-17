<?php

namespace App\Repositories;

use App\Models\AuctionTiePreference;

class TiePreferenceRepository
{
    public function create($data)
    {
        foreach ($data as $key => $value) {
            AuctionTiePreference::create(['team_id' => $key, 'number' => $value]);
        }

        return true;
    }

    public function delete($data)
    {
        $delete = AuctionTiePreference::whereIn('team_id', $data)->delete();

        return $delete;
    }
}
