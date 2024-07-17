<?php

namespace App\Enums\PlayerContractPosition;

use App\Enums\Enum;

final class AllPositionEnum extends Enum
{
    const GOALKEEPER = 'Goalkeeper (GK)';
    const FULLBACK = 'Full-back (FB)';
    const CENTREBACK = 'Centre-back (CB)';
    const DEFENDER = 'Defender (DF)';
    const DEFENSIVE_MIDFIELDER = 'Defensive Midfielder (DMF)';
    const MIDFIELDER = 'Midfielder (MF)';
    const STRIKER = 'Striker (ST)';
}