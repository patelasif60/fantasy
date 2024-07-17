<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class AgentTransferAfterEnum extends Enum implements LocalizedEnum
{
    const AUCTIONEND = 'auctionEnd';
    const SEASONSTART = 'seasonStart';
}
