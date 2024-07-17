<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class TiePreferenceEnum extends Enum implements LocalizedEnum
{
    const NO = 'no';
    const EARLIEST_BID_WINS = 'earliestBidWins';
    const LOWER_LEAGUE_POSITION_WINS = 'lowerLeaguePositionWins';
    const HIGHER_LEAGUE_POSITION_WINS = 'higherLeaguePositionWins';
    const RANDOMLY_ALLOCATED = 'randomlyAllocated';
    const RANDOMLY_ALLOCATED_REVERSES = 'randomlyAllocatedReverses';
}
