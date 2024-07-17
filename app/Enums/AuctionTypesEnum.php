<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class AuctionTypesEnum extends Enum implements LocalizedEnum
{
    // const LIVE = 'Live';
    // const ONLINE = 'Online';
    const OFFLINE_AUCTION = 'Live offline';
    const ONLINE_SEALED_BIDS_AUCTION = 'Online sealed bids';
    const LIVE_ONLINE_AUCTION = 'Live online';
}
