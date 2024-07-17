<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class HistoryPeriodEnum extends Enum implements LocalizedEnum
{
    const SEVEN_DAYS = '7 days';
    const THIRTY_DAYS = '30 days';
    const SEASON = 'Season';
}
