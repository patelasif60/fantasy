<?php

namespace App\Repositories;

use App\Models\PointAdjustment;
use App\Models\Season;

class PointAdjustmentRepository
{
    public function create($data)
    {
        $adjustment['points'] = $data['points'];
        $adjustment['note'] = $data['note'];
        $adjustment['competition_type'] = $data['competition_type'];
        $adjustment['team_id'] = $data['team_id'];
        $adjustment['season_id'] = Season::getLatestSeason();

        return PointAdjustment::create($adjustment);
    }
}
