<?php

namespace App\Enums\Division;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class AuctionTypeEnum extends Enum implements LocalizedEnum
{
    const SEALEDBIDSAUCTION = 'sealedBidsAuction';
    const REALTIMEAUCTION = 'realTimeAuction';
    const MANUALENTRY = 'manualEntry';
}
