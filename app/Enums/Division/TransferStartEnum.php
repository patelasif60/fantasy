<?php

namespace App\Enums\Division;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class TransferStartEnum extends Enum implements LocalizedEnum
{
    const SESSIONSTART = 'sessionStart';
    const SESSIONEND = 'sessionEnd';
}
