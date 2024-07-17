<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class DivisionPhasesEnum extends Enum implements LocalizedEnum
{
    const AUCTION = 'auction';
    const SEASON = 'season';
}
