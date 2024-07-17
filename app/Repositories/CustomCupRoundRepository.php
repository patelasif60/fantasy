<?php

namespace App\Repositories;

class CustomCupRoundRepository
{
    public function create($customCup, $data)
    {
        $round = $customCup->rounds()->create([
            'round' => $data,
        ]);

        return $round;
    }
}
