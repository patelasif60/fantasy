<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class HeadToHeadFixturesStatusEnum extends Enum
{
    const FIXTURE = 'Fixture';
    const PLAYING = 'Playing';
    const PLAYED = 'Played';
    const AWARDED = 'Awarded';
}
