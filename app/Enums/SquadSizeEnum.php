<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class SquadSizeEnum extends Enum implements LocalizedEnum
{
    const SQUAD_SIZE_MAX = 18;
    const SQUAD_LINEUP = 11;
    const SQUAD_SUBSTITUTE = 7;
}
