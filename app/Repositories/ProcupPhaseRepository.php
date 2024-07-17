<?php

namespace App\Repositories;

class ProcupPhaseRepository
{
    public function create($gameweek, $size, $name)
    {
        return $gameweek->proCupPhases()->create([
            'size' => $size,
            'name' => $name,
        ]);
    }

    public function update($proCup, $name)
    {
        $proCup->fill([
            'name' => $name,
        ]);

        return $proCup->save();
    }
}
