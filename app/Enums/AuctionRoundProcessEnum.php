<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class AuctionRoundProcessEnum extends Enum implements LocalizedEnum
{
    const PROCESSED = 'P';
    const UNPROCESSED = 'U';
}
