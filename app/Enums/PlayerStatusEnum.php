<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class PlayerStatusEnum extends Enum implements LocalizedEnum
{
    const SUSPENDED = 'Suspended';
    const LATE_FITNESS_TEST = 'Late Fitness Test';
    const DOUBTFUL = 'Doubtful';
    const INJURED = 'Injured';
    const INTERNATIONAL = 'International';
}
