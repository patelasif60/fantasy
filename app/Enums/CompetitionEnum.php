<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class CompetitionEnum extends Enum implements LocalizedEnum
{
    const PREMIER_LEAGUE = 'Premier League';
    const FA_CUP = 'FA Cup';
}
