<?php

namespace App\Repositories;

class CustomCupTeamRepository
{
    public function create($customCup, $data)
    {
        $customCup->teams()->create([
            'team_id' => $data['team_id'],
            'is_bye' => $data['is_bye'],
        ]);

        return $customCup;
    }
}
