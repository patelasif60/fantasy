<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class EuropeanPhasesNameEnum extends Enum implements LocalizedEnum
{
    const __default = self::CHAMPIONS_LEAGUE;

    const CHAMPIONS_LEAGUE = 'Champions League';
    const EUROPA_LEAGUE = 'Europa League';

    const EUROPA = 'europa';
    const CHAMPION = 'champion';
}
