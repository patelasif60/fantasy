<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class UserStatusEnum extends Enum implements LocalizedEnum
{
    const __default = self::ACTIVE;

    const ACTIVE = 'Active';
    const SUSPENDED = 'Suspended';
}
