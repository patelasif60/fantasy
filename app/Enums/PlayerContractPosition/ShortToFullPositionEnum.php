<?php

namespace App\Enums\PlayerContractPosition;

use App\Enums\Enum;

final class ShortToFullPositionEnum extends Enum
{
    const GK = 'Goalkeeper (GK)';
    const FB = 'Full-back (FB)';
    const CB = 'Centre-back (CB)';
    const DF = 'Defender (DF)';
    const DMF = 'Defensive Midfielder (DMF)';
    const MF = 'Midfielder (MF)';
    const ST = 'Striker (ST)';
}
