<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class DigitalPrizeTypeEnum extends Enum implements LocalizedEnum
{
    const STANDARD = 'Standard';
    const BASIC = 'Basic';
}
