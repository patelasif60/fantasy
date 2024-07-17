<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class TransferErrorEnum extends Enum implements LocalizedEnum
{
    const TEAM_FULL = 'teamFull';
    const TEAM_LINEUP_FULL = 'teamLineupFull';
}
