<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class FixtureEventHalfEnum extends Enum implements LocalizedEnum
{
    const FIRST_HALF = 1;
    const SECOND_HALF = 2;
    const EXTRA_TIME_FIRST_HALF = 3;
    const EXTRA_TIME_SECOND_HALF = 4;
}
