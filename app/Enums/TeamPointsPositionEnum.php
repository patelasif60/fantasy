<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TeamPointsPositionEnum extends Enum
{
    const GOAL_KEEPER = 'Goalkeeper (GK)';
    const FULL_BACK = 'Full-back (FB)';
    const CENTRE_BACK = 'Centre-back (CB)';
    const DEFENSIVE_MID_FIELDER = 'Defensive Midfielder (DMF)';
    const MID_FIELDER = 'Midfielder (MF)';
    const STRIKER = 'Striker (ST)';
}
