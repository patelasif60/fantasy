<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class YesNoEnum extends Enum implements LocalizedEnum
{
    const YES = 'Yes';
    const NO = 'No';
}
