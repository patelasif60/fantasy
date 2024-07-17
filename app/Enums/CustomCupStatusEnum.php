<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class CustomCupStatusEnum extends Enum implements LocalizedEnum
{
    const __default = self::PENDING;

    const ACTIVE = 'Active';
    const PENDING = 'Pending';
}
