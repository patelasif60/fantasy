<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OnlineSealedBidStatusEnum extends Enum
{
    const WON = 'W';
    const LOST = 'L';
    const PENDING = 'P';
}
