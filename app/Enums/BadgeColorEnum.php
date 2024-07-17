<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class BadgeColorEnum extends Enum implements LocalizedEnum
{
    const GREEN = 'green';
    const SILVER = 'silver';
    const GOLD = 'gold';
}
