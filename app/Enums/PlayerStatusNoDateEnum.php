<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class PlayerStatusNoDateEnum extends Enum implements LocalizedEnum
{
    const LATE_FITNESS_TEST = 'Late Fitness Test';
    const DOUBTFUL = 'Doubtful';
}
