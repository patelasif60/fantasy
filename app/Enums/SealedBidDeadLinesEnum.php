<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class SealedBidDeadLinesEnum extends Enum implements LocalizedEnum
{
    const DONTREPEAT = 'dontRepeat';
    const EVERYMONTH = 'everyMonth';
    const EVERYFORTNIGHT = 'everyFortnight';
    const EVERYWEEK = 'everyWeek';
}
