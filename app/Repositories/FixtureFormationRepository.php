<?php

namespace App\Repositories;

use App\Models\FixtureFormation;

class FixtureFormationRepository
{
    public function getFormations()
    {
        return FixtureFormation::all();
    }
}
