<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class PositionsEnum extends Enum implements LocalizedEnum
{
    const GOAL_KEEPER = 'goal_keeper';
    const CENTER_BACK = 'centre_back';
    const FULL_BACK = 'full_back';
    const DEFENSIVE_MIDFIELDER = 'defensive_mid_fielder';
    const MIDFIELDER = 'mid_fielder';
    const STRIKER = 'striker';
}
