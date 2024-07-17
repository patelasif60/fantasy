<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class PointAdjustmentsEnum extends Enum implements LocalizedEnum
{
    const REGULAR_SEASON = 'regular';
    const FA_CUP = 'cup';
}
