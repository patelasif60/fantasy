<?php

namespace App\Enums\Division;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class YesNoEnum extends Enum implements LocalizedEnum
{
    const YES = 'Yes';
    const NO = 'No';
}
